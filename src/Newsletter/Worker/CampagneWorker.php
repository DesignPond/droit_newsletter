<?php namespace designpond\newsletter\Newsletter\Worker;

use designpond\newsletter\Newsletter\Repo\NewsletterContentInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterUserInterface;
use \InlineStyle\InlineStyle;

class CampagneWorker implements CampagneInterface{

    protected $content;
    protected $campagne;
    protected $newsletter;
    protected $subscription;

	public function __construct(NewsletterContentInterface $content, NewsletterCampagneInterface $campagne, NewsletterInterface $newsletter, NewsletterUserInterface $subscription)
	{
        $this->content      = $content;
        $this->campagne     = $campagne;
        $this->newsletter   = $newsletter;
        $this->subscription = $subscription;
	}

    /**
     * Interaction with site controllers
     * List of arrets in non sent campagne to hide on frontend
     */
    public function arretsToHide($newsletter_id = null)
    {
        $campagnes = $this->campagne->getAll($newsletter_id)->where('status','brouillon');

        return $campagnes->flatMap(function ($campagne) {
                return $campagne->content;
            })->map(function ($content, $key) {

                if($content->arret_id)
                    return $content->arret_id ;

                if($content->groupe_id > 0)
                    return $content->groupe->arrets->lists('id')->all();
            
            })->filter(function ($value, $key) {
                return !empty($value);
            })->flatten()->toArray();
    }

    /**
     * Get campagne for site
     */
    public function getCampagne($id)
    {
        return $this->campagne->find($id);
    }

    /**
     * Last sent campagne for site
     */
    public function last($newsletter_id = null)
    {
        return $this->campagne->getLastCampagne($newsletter_id);
    }


    /**
     * Archives by year
     */
    public function getArchives($newsletter_id,$year)
    {
        return $this->campagne->getArchives($newsletter_id,$year);
    }

    /**
     * All newsletter for site
     */
    public function siteNewsletters($site_id)
    {
        if(config('newsletter.multi'))
        {
            return $this->newsletter->getSite($site_id);
        }

        return null;
    }

    /**
     * All campagnes for site
     */
    public function siteCampagnes($site_id)
    {
        if(config('newsletter.multi')) {
            $newsletters = $this->newsletter->getSite($site_id);
            return $newsletters->map(function ($newsletter, $key) {
                return $newsletter->campagnes;
            })->flatten(1);
        }

        return null;
    }
    
    /**
     * Get subscriptions for given email
     * @param $email
     * @return Newsletter_users model
     */
    public function hasSubscriptions($email)
    {
        return $this->subscription->findByEmail($email);
    }
    
    /**
     * Put styles inline for campagne
     * Used when sending cammpagne or test 
     * */
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
