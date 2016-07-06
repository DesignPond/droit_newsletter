var url  = location.protocol + "//" + location.host+"/";

$(function() {

    $( "#sortable" ).sortable({
        axis: 'y',
        handle: '.handle',
        placeholder: "ui-state-highlight",
        start: function (event, ui) {

            ui.item.css("height","80px");
            ui.item.css("overflow","hidden");

            var $title  = ui.item.find('h2.ng-binding').text();
            var $group  = ui.item.find('h3.mainTitle').text();

            var titre   = $title? $title : $group;
            var $holder = '<span id="holder">' + titre + '</span>';

            ui.item.prepend($holder);

            console.log($group);
        },
        stop: function (event, ui) {
            $("span#holder").detach();
            ui.item.css("height","auto");
            ui.item.css("overflow","normal");
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


    $( "#sortable_list" ).sortable({
        axis: 'y',
        placeholder: "ui-state-highlight",
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