var App = angular.module('newsletter', ["angular-redactor","flow","ngSanitize","dndLists"] , function($interpolateProvider)
{
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');

}).config(function(redactorOptions) {
        /* Redactor wysiwyg editor configuration */
        redactorOptions.minHeight        = 120;
        redactorOptions.maxHeight        = 240;
        redactorOptions.formattingTags   = ['p', 'h2', 'h3','h4'];
        redactorOptions.fileUpload       = 'admin/uploadRedactor?_token=' + $('meta[name="_token"]').attr('content');
        redactorOptions.imageUpload      = 'admin/uploadRedactor?_token=' + $('meta[name="_token"]').attr('content');
        redactorOptions.imageManagerJson = 'admin/imageJson';
        redactorOptions.fileManagerJson  = 'admin/fileJson';
        redactorOptions.plugins          = ['imagemanager','filemanager'];
        redactorOptions.lang             = 'fr';
        redactorOptions.buttons          = ['html','|','formatting','bold','italic','|','unorderedlist','orderedlist','outdent','indent','|','image','file','link','alignment'];

}).config(['flowFactoryProvider', function (flowFactoryProvider) {
        /* Flow image upload configuration */
        flowFactoryProvider.defaults = {
            target: 'admin/uploadJS',
            testChunks:false,
            singleFile: true,
            query:{ _token : $("meta[name='_token']").attr('content') } ,
            permanentErrors: [404, 500, 501],
            simultaneousUploads: 4
        };
}]).service('myService',  function ($rootScope) {
    var blocDrop = 0;
    return {
        getBloc : function() {
            return blocDrop;
        },
        setBloc : function(bloc) {
            $('.edit_content_form').hide();
            blocDrop = bloc;
        },
        convertDateArret: function(date){

            var jsonObject  = date.substr(0,10);
            var convertdate = new Date(jsonObject);

            var months  = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
            var newdate = convertdate.getDate();
            if (newdate < 10)
            {
                newdate = "0" + newdate;
            }
            var output = newdate + " " + months[convertdate.getMonth()] + " " + convertdate.getFullYear();
            return output;
        },
        convertArret: function(data, models){

            angular.forEach( data , function(value, key){
                models.lists.A.push({
                    reference    : value.reference,
                    isSelected   : false,
                    itemId       : value.id
                });
            });

            return models;
        },
        convertCategories: function(data, models){

            angular.forEach( data , function(value, key){
                models.lists.A.push({
                    title      : value.title,
                    isSelected : false,
                    itemId     : value.id
                });
            });

            return models;
        }
    };
});

/**
 * Retrive all arrets blocs for bloc arret
 */
App.factory('Arrets', ['$http', '$q', function($http, $q) {
    return {
        query: function() {
            var deferred = $q.defer();
            $http.get('/admin/ajax/arrets', { cache: true }).success(function(data) {
                deferred.resolve(data);
            }).error(function(data) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
        simple: function(id) {
            var deferred = $q.defer();
            $http.get('/admin/ajax/arrets/'+ id).success(function(data) {
                deferred.resolve(data);
            }).error(function(data) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
}]);


/**
 * Form controller, controls the form for creating new content blocs
 */
App.controller("CreateController",['$scope','$http','myService', function($scope,$http,myService){

    $scope.$on('flow::fileError', function (event, $flow, flowFile) {
        event.preventDefault();//prevent file from uploading
        $flow.removeFile(flowFile);
        $('.errorUpload').html('Le fichier est trop volumineux').show();
    });

    $scope.$on('flow::fileAdded', function (event, $flow, flowFile) {
        $('.errorUpload').hide();
    });

}]);


/**
 * Form controller, controls the form for creating new content blocs
 */
App.controller("EditController",['$scope','$http','myService', function($scope,$http,myService){

    $scope.$on('flow::fileError', function (event, $flow, flowFile) {
        event.preventDefault();//prevent file from uploading
        $flow.removeFile(flowFile);
        $('.errorUpload').html('Le fichier est trop volumineux').show();
    });

    $scope.$on('flow::fileAdded', function (event, $flow, flowFile) {
        $('.errorUpload').hide();
    });

    $scope.editable = 0;

    this.onedit = function(id){
        return id == $scope.editable;
    };

    this.handleErrorsUpload = function($file, $message, $flow){
        console.log($message);
    };

    this.close = function(){
        $('.edit_content_form').hide();
    };

    this.finishEdit = function(idItem){

        $('.edit_content_form').hide();

        if(idItem)
        {
            console.log(idItem);

            $( "#sortGroupe_" + idItem ).sortable( "disable" );
            $( ".sortGroupe .groupe_rang").css({ "border":"none"});
        }

        $('.finishEdit').hide();
        $('.editContent').show();
        $( "#sortable" ).sortable( "enable" );
    }

    this.editContent = function(idItem){

        var w = $( document ).width();
        w = w - 890;

        myService.setBloc(0);

        $scope.editable = idItem;

        $('.edit_content_form').hide();

        var content = $('#bloc_rang_'+idItem);
        content.find('.edit_content_form').css("width",w).show();

        $( "#sortable" ).sortable( "disable" );
        content.find('.finishEdit').show();

        var groupe_id = content.find('.sortGroupe').data('group');

        $( "#sortGroupe_" + groupe_id ).sortable({
            axis: 'y',
            update: function (event, ui) {
                var data = $(this).sortable('serialize') +"&groupe_id="+ groupe_id + "&_token=" + $("meta[name='_token']").attr('content');
                // POST to server using $.post or $.ajax
                $.ajax({
                    data: data,
                    type: 'POST',
                    url: url+ 'admin/sortingGroup'
                });
            }
        });

        $( "#sortGroupe_" + groupe_id ).sortable( "enable" );
        $( "#sortGroupe_" + groupe_id).find('.groupe_rang').css('border','1px solid #bfe4ad');

    };

}]);

/**
 * Select arret controller, select an arret and display's it
 */
App.controller('SelectController', ['$scope','$http','Arrets','myService',function($scope,$http,Arrets,myService){

    /* assign empty values for arrets */
    this.arrets = [];
    this.arret  = false;
    /* capture this (the controller scope ) as self */
    var self = this;

    /* function for refreshing the asynchronus retrival of blocs */
    this.refresh = function() {
        Arrets.query()
            .then(function (data) {
                self.arrets = data;
            });
    }

    if(self.arrets.length == 0){
        this.refresh();
    }

    this.close = function(){
        myService.setBloc(0);
        $('.edit_content_form').hide();
    };

    /* When one arret is selected in the dropdown */
    this.changed = function(){

        /* hide arret */
        self.arret      = false;
        self.categories = false;
        self.date       = new Date();

        /* Get the id of arret */
        var id = $scope.selected.id

        /* Get the selected arret infos */
        Arrets.simple(id)
            .then(function (data) {
                self.arret = data;
                self.categories = data.arrets_categories;

                //get substring
                self.date = myService.convertDateArret(self.arret.pub_date)
            });
    };

}]);


App.controller("MultiSelectionController",['$scope',"Arrets","myService", function($scope,Arrets,myService){

    /* capture this (the controller scope ) as self */
    var self = this;

    this.items = [];
    this.type  = '';

    self.models = {
        selected: null,
        lists: {"A": [], "B": []}
    };

    /* function for refreshing the asynchronus retrival of blocs */
    this.refresh = function() {

        Arrets.query()
            .then(function (data) {

                self.items  = data;
                //console.log(self.items);
                self.models = myService.convertArret(self.items, self.models);

            });
    }

    if(self.items.length == 0){
        self.refresh();
    }

    this.dropped = function(item){

        angular.forEach(self.models.lists.B, function(value, key){
            value.isSelected = true;
        });
        angular.forEach(self.models.lists.A, function(value, key){
            value.isSelected = false;
        });

    };

}]);


App.directive('bindContent', function() {
    return {
        require: 'ngModel',
        link: function ($scope, $element, $attrs, ngModelCtrl) {
            ngModelCtrl.$setViewValue($element.text());
            ngModelCtrl.$setViewValue($element.val());
        }
    }
});
