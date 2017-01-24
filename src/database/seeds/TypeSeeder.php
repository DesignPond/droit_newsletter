<?php
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run()
    {
        \DB::table('newsletter_types')->truncate();

        $newsletter_types = array(
            array('id' => '1','titre' => 'Image','image' => 'image.svg','partial' => 'image','template' => 'image','elements' => 'image'),
            array('id' => '2','titre' => 'Text et image','image' => 'imageText.svg','partial' => 'imageText','template' => 'image-text','elements' => 'titre,texte,image'),
            array('id' => '3','titre' => 'Text et image à droite','image' => 'imageRightText.svg','partial' => 'imageRightText','template' => 'image-right-text','elements' => 'titre,texte,image'),
            array('id' => '4','titre' => 'Text et image à gauche','image' => 'imageLeftText.svg','partial' => 'imageLeftText','template' => 'image-left-text','elements' => 'titre,texte,image'),
            array('id' => '5','titre' => 'Arrêt','image' => 'arret.svg','partial' => 'arret','template' => 'arret','elements' => 'arret'),
            array('id' => '6','titre' => 'Text','image' => 'text.svg','partial' => 'text','template' => 'text','elements' => 'texte'),
            array('id' => '7','titre' => 'Groupe','image' => 'groupe.svg','partial' => 'groupe','template' => 'groupe','elements' => 'arret'),
            array('id' => '8','titre' => 'Livre','image' => 'product.svg','partial' => 'product','template' => 'product','elements' => 'product'),
            array('id' => '9','titre' => 'Colloque','image' => 'colloque.svg','partial' => 'colloque','template' => 'colloque','elements' => 'colloque')
        );

        \DB::table('newsletter_types')->insert($newsletter_types);

    }
}