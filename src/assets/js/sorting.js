var url  = location.protocol + "//" + location.host+"/";

$(function() {

    $( "#sortable" ).sortable({
        axis: 'y',
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            var data = $(this).sortable('serialize') +"&_token=" + $("meta[name='_token']").attr('content');
            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                type: 'POST',
                url: url+ 'admin/campagne/sorting'
            });
        }
    });

});