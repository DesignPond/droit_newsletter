$(function() {

    var url = location.protocol + "//" + location.host+"/";

    $('.colorpicker').colorPicker();

    var $selects = $('.chooseCategorie');

    var site_id = $('#main').data('site');
    site_id = !site_id ? null : site_id;

    $selects.each(function (index, value) {

        var self = $(this);

        jQuery.ajax({
            dataType: 'json',
            success: function(data)
            {
                var items = [];
                // Loop over ajax data response
                jQuery.each(data, function(key, val) {
                    items.push('<option value="' + val.id + '">' + val.title + '</option>');
                });
                // Join all html, append to select and show the select
                var all = items.join('');

                self.append(all);
            },
            url: window.__env.ajaxUrl + 'categories/' + site_id
        });

    });

    //datePickerNewsletter

    $('#datePickerNewsletter').datetimepicker({
        locale: 'fr-ch',
        format:  'YYYY-MM-DD HH:mm',
        minDate : moment().format()
    });

    $('body').on('click','.deleteActionNewsletter',function(event){

        var $this  = $(this);
        var action = $this.data('action');
        var id     = $this.data('id');
        var _token = $("meta[name='_token']").attr('content');
        var answer = confirm('Voulez-vous vraiment supprimer : '+ action +' ?');

        if (answer)
        {
            $.ajax({
                url     : url + 'build/content/' + id,
                data    : { id: id , _token : _token},
                type    : "DELETE",
                success : function(data) {
                    if(data == 'ok')
                    {
                        $('#bloc_rang_'+id).remove();
                    }
                }
            });
        }
        return false;
    });

    $('body').on('click','.deleteNewsAction',function(event){

        var $this  = $(this);
        var action = $this.data('action');
        var what   = $this.data('what');

        var what = (0 === what.length ? 'supprimer' : what);
        var answer = confirm('Voulez-vous vraiment ' + what + ' : '+ action +' ?');

        if (answer){
            return true;
        }
        return false;
    });

    /**
     *  Create and edit newsletter blocs
     */
    $('body').on('click','.editContent',function(event){

        var $this  = $(this);
        var id     = $this.data('id');

        $('.create_bloc').hide();
        $('.edit_content_form').hide();

        $('#edit_'+id).show();

        $( "#sortGroupe" ).sortable( "enable" );
        $( "#sortGroupe .groupe_rang").css({ "border":"1px solid #bfe4ad"});

    });

    $('body').on('click','.cancelEdit',function(event){

        $('.edit_content_form').hide();
        $( "#sortGroupe" ).sortable( "disable" );
        $('.bloc_rang').height('auto');
    });

    $('body').on('click','.cancelCreate',function(event){
        $('.create_bloc').hide();
    });

    $('body').on('click','.blocEdit',function(event){
        var $this  = $(this);
        var id     = $this.attr('rel');
        var w = $( document ).width();
        w = w - 600 - w/4;
        var h = $( document ).height();

        $('.create_bloc').hide();
        $('.edit_content_form').hide();

        var content = $('#create_'+id);
        content.find('.create_content_form').css("width",w);

        setTimeout(function() {
            // height
            var h = $('#create_'+id + ' .create_content_form').height();
            $('#create_'+id).css("height",h-100);

        }, 100);

        $('#create_'+id).show();
    });

});
