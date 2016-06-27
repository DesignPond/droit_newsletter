var App = angular.module('selection', ["dndLists"] , function($interpolateProvider)
{
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');

}).service('myService',  function ($rootScope,$filter) {
    return {
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
        convertArret: function(data, models,selected){

            angular.forEach( data , function(value, key) {

                var result = [];

                if(selected){
                    result = $.grep(selected, function (e) {
                        return e.id == value.id;
                    });
                }

                if (result.length == 0){
                    models.lists.A.push({
                        reference: value.reference,
                        isSelected: false,
                        itemId: value.id
                    });
                }
            });

            if(selected){
                angular.forEach( selected , function(value, key){
                    models.lists.B.push({
                        reference    : value.reference,
                        isSelected   : true,
                        itemId       : value.id
                    });
                });
            }

            return models;
        },
        convertCategories: function(data, models, selected){

            angular.forEach(data, function (value, key) {

                var result = [];

                if(selected){
                    result = $.grep(selected, function (e) {
                        return e.id == value.id;
                    });
                }

                if (result.length == 0) {
                    models.lists.A.push({
                        title      : value.title,
                        parent     : value.parent ? value.parent.id :'',
                        image      : value.image.slice(0, -4),
                        isSelected : false,
                        itemId     : value.id
                    });
                }
            });

            if(selected){
                angular.forEach( selected , function(value, key){
                    models.lists.B.push({
                        title      : value.title,
                        parent     : value.parent_id,
                        image      : value.image.slice(0, -4),
                        isSelected : true,
                        itemId     : value.id
                    });
                });

                console.log(selected);
            }

            return models;
        }
    };
});


App.filter('getById', function() {
    return function(collection, id) {

        angular.forEach( collection , function(value, key){
            if(value.id == id){
                return id;
            }
        });

        return null;
    }
});


/**
 * Retrive all arrets blocs for bloc arret
 */
App.factory('Arrets', ['$http', '$q', function($http, $q) {
    return {
        query: function() {
            var deferred = $q.defer();
            $http.get(window.__env + 'arrets', { cache: true }).success(function(data) {
                deferred.resolve(data);
            }).error(function(data) {
                deferred.reject(data);
            });
            return deferred.promise;
        },
        simple: function(id) {
            var deferred = $q.defer();
            $http.get(window.__env + 'arrets/'+ id).success(function(data) {
                deferred.resolve(data);
            }).error(function(data) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
}]);


/**
 * Retrive all arrets blocs for bloc arret
 */
App.factory('Analyses', ['$http', '$q', function($http, $q) {
    return {
        simple: function(id) {
            var deferred = $q.defer();
            $http.get(window.__env + 'analyses/'+ id).success(function(data) {
                deferred.resolve(data);
            }).error(function(data) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
}]);

/**
 * Retrive all arrets blocs for bloc arret
 */
App.factory('Categories', ['$http', '$q', function($http, $q) {
    return {
        query: function() {
            var deferred = $q.defer();
            $http.get( window.__env + 'categories').success(function(data) {
                deferred.resolve(data);
            }).error(function(data) {
                deferred.reject(data);
            });
            return deferred.promise;
        }
    };
}]);

App.controller("MultiSelectionController",['$scope',"$filter","Categories","Arrets","Analyses","myService", function($scope,$filter,Categories,Arrets,Analyses,myService){

    /* capture this (the controller scope ) as self */
    var self = this;

    this.items = [];
    this.items_categories = [];
    this.items_arrets = [];
    this.type  = '';

    self.models = {
        selected: null,
        lists: {"A": [], "B": []}
    };

    /* function for refreshing the asynchronus retrival of blocs */
    this.refresh = function() {

        if( $scope.typeItem == 'categories'){

            Categories.query()
                .then(function (data) {

                    self.items  = data;

                    if($scope.uidContent && $scope.itemContent)
                    {
                        if ($scope.itemContent == 'arrets')
                        {
                            Arrets.simple($scope.uidContent)
                                .then(function (data) {
                                    self.items_categories = data.arrets_categories;
                                    self.models = myService.convertCategories(self.items, self.models, self.items_categories);
                                });
                        }
                        else
                        {
                            /* Get the selected arret infos */
                            Analyses.simple($scope.uidContent)
                                .then(function (data) {
                                    self.items_categories = data.analyses_categories;
                                    self.models = myService.convertCategories(self.items, self.models, self.items_categories);
                                });
                        }
                    }
                    else
                    {
                        self.models = myService.convertCategories(self.items, self.models);
                    }

                });
        }

        if( $scope.typeItem == 'arrets'){

            Arrets.query()
                .then(function (data) {
                    self.items  = data;
                    console.log(self.items);
                    if($scope.uidContent && $scope.itemContent) {

                        /* Get the selected analyse infos */
                        Analyses.simple($scope.uidContent)
                            .then(function (data) {
                                self.items_arrets = data.analyses_arrets;
                                self.models = myService.convertArret(self.items, self.models, self.items_arrets);

                            });
                    }
                    else
                    {
                        self.models = myService.convertArret(self.items, self.models);
                    }

                });
        }

    }

    if(self.items.length == 0){
        $scope.$watch("typeItem", function(){
            self.refresh();
        });
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
