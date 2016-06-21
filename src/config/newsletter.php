<?php

return [

    /*
     * Mailjet API credentials
     * */

    'mailjet' => [
        'api'    => env('MAILJET_API'),
        'secret' => env('MAILJET_SECRET'),
    ],

    /*
     * Is used with Arrets and Categories
     * */
    'components' => [
        1 => 'Image',
        2 => 'Text et image',
        3 => 'Text et image à droite',
        4 => 'Text et image à gauche',
        5 => 'Arrêt',
        6 => 'Text',
       // 7 => 'Groupe'
    ],

    /*
     * Define Arrets and Categories models
     * */
    'models' => [
        'arret'  => 'App\Droit\Arret\Entities\Arret',
        'groupe' => 'App\Droit\Arret\Entities\Groupe',
    ]
];