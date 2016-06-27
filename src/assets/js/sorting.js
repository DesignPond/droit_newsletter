var url  = location.protocol + "//" + location.host+"/";

$(function() {

    $( "#sortable" ).sortable({
        axis: 'y',
        placeholder: "ui-state-highlight",
        start: function (event, ui) {
            ui.item.css("height","100px");
            ui.item.css("overflow","hidden");
        },
        stop: function (event, ui) {
            //ui.item.toggleClass("highlight");
        },
        update: function (event, ui) {
            var data = $(this).sortable('serialize');
            var data = $(this).sortable('serialize') +"&_token=" + $("meta[name='_token']").attr('content');
            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                type: 'POST',
                url: url + 'build/sorting'
            });
        }
    });

});