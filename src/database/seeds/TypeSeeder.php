<?php
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run()
    {
        \DB::table('newsletter_types')->truncate();

        $newsletter_types = [
            ['titre' => 'Image','image' => 'image.svg','partial' => 'image','template' => 'image','elements' => 'image'],
            ['titre' => 'Text et image','image' => 'imageText.svg','partial' => 'imageText','template' => 'image-text','elements' => 'titre,texte,image'],
            ['titre' => 'Text et image à droite','image' => 'imageRightText.svg','partial' => 'imageRightText','template' => 'image-right-text','elements' => 'titre,texte,image'],
            ['titre' => 'Text et image à gauche','image' => 'imageLeftText.svg','partial' => 'imageLeftText','template' => 'image-left-text','elements' => 'titre,texte,image'],
            ['titre' => 'Arrêt','image' => 'arret.svg','partial' => 'arret','template' => 'arret','elements' => 'arret'],
            ['titre' => 'Text','image' => 'text.svg','partial' => 'text','template' => 'text','elements' => 'texte'],
            ['titre' => 'Groupe','image' => 'groupe.svg','partial' => 'groupe','template' => 'groupe','elements' => 'arret']
        ];

        \DB::table('newsletter_types')->insert($newsletter_types);

    }
}