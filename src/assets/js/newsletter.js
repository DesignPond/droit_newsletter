
$(function() {

    if(window){
        Object.assign(__env, window.__env);
    }

    $('.sendEmailNewsletter').click(function(){

        var campagneId = $(this).data('campagne');
        var message    = $('#messageAlert');

        bootbox.prompt("Envoyer à cette adresse email", function(result) {
            if (result === null) { alert('Vous n\'avez pas indiqué d\'adresse email'); }
            else
            {
                message.find('.alert').addClass('alert-warning');
                message.find('.alert p').html('Email de test en cours d\'envoi &nbsp;<i class="fa fa-spinner fa-spin"></i>').show();

                $.ajax({
                    url     : __env.__env.adminUrl + 'campagne/test',
                    data    : { id: campagneId , email: result, send_type : 'ajax', _token : $("meta[name='_token']").attr('content')},
                    type    : "POST",
                    success : function(data) {
                        if(data)
                        {
                            message.find('.alert').removeClass('alert-warning');
                            message.find('.alert').addClass('alert-success');
                            message.find('.alert p').text('Email de test envoyé!');

                            window.setTimeout(function() {
                                $(message).fadeTo(500, 0).slideUp(500, function(){
                                    $(this).remove();
                                });
                            }, 3500);

                        }
                    }
                });

            }
        });
    });

    $('#bootbox').click(function(){
        var campagneId = $(this).data('campagne');
        var sujet      = '';

        /*  Get campagne infos */
        $.get( window.__env.adminUrl + 'campagne/simple/' + campagneId , function( campagne ) {
            sujet = campagne.sujet;
            console.log(sujet);
        }) .always(function() {

            /*  Modal */
            bootbox.dialog({
                message: "Etes-vous sûr de vouloir envoyer la campagne : <strong>" + sujet + "</strong>?",
                title: "Envoyer la campagne",
                buttons: {
                    success: {
                        label: "Oui!",
                        className: "btn-success",
                        callback: function() {
                            $("#sendCampagneForm").submit();
                        }
                    },
                    main: {
                        label: "Annuler",
                        className: "btn-default"
                    }
                }
            });
        });
    });

});
