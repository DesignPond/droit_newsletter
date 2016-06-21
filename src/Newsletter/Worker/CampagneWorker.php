<?php namespace designpond\newsletter\Newsletter\Worker;

use designpond\newsletter\Newsletter\Repo\NewsletterContentInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface;
use \InlineStyle\InlineStyle;

class CampagneWorker implements CampagneInterface{

    protected $content;
    protected $campagne;

	public function __construct(NewsletterContentInterface $content, NewsletterCampagneInterface $campagne)
	{
        $this->content   = $content;
        $this->campagne  = $campagne;
	}

    public function arretsToHide()
    {
        $campagnes = $this->campagne->getAll()->where('status','brouillon');

        return $campagnes->flatMap(function ($campagne) {
                return $campagne->content;
            })->map(function ($content, $key) {

                if($content->arret_id)
                    return $content->arret_id ;

                if($content->groupe_id > 0)
                    return $content->groupe->arrets_groupes->lists('id')->all();

            })->filter(function ($value, $key) {
                return !empty($value);
            })->flatten()->toArray();
    }

    public function infos($id)
    {
        return $this->campagne->find($id);
    }

    public function html($id)
    {
        libxml_use_internal_errors(true);

        $htmldoc = new InlineStyle(file_get_contents( url('campagne/'.$id)));
        $htmldoc->applyStylesheet($htmldoc->extractStylesheets());

        $html = $htmldoc->getHTML();
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);

        return $html;
    }
}
