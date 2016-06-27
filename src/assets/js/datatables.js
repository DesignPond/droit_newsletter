// -------------------------------
// Initialize Data Tables
// -------------------------------

if(window){
    Object.assign(__env, window.__env);
}

$(document).ready(function() {

    var langues = {
        processing:     "Traitement en cours...",
        search:         "Rechercher&nbsp;:",
        lengthMenu:     "Afficher _MENU_ &eacute;l&eacute;ments",
        info:           "Affichage de _START_ &agrave; _END_ sur _TOTAL_ lignes",
        infoEmpty:      "Affichage de 0 &agrave; 0 sur 0 lignes",
        infoFiltered:   "(filtr&eacute; de _MAX_ lignes au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable:     "Aucune donnée disponible",
        paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
        },
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    };

    var url = location.protocol + "//" + location.host+"/";

    var table = $('.abonnes_table').DataTable({
        "serverSide": true,
        "ajax": {
            "url": __env.adminUrl + "build/subscribers"
        },
        "columns": [
            {
                data: 'id',
                title: 'Editer'
            },
            {
                data: 'status'
            },
            {
                data: 'activated_at',
                title: 'Activé le'
            },
            {
                data: 'email'
            },
            {
                data: 'abo'
            },
            {
                data: 'delete'
            }
        ],
        language: langues
    });

    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Recherche...');
    $('.dataTables_length select').addClass('form-control');
});