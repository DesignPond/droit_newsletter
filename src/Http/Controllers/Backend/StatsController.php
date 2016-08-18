<?php

namespace designpond\newsletter\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use designpond\newsletter\Newsletter\Worker\MailjetServiceInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface;
use designpond\newsletter\Newsletter\Worker\StatsWorker;

class StatsController extends Controller
{
    protected $worker;
    protected $campagne;
    protected $statsworker;
    protected $charts;

    public function __construct( MailjetServiceInterface $worker, NewsletterCampagneInterface $campagne, StatsWorker $statsworker)
    {
        $this->worker       = $worker;
        $this->campagne     = $campagne;
        $this->statsworker  = $statsworker;
        $this->charts       = new \designpond\newsletter\Newsletter\Worker\Charts();

        setlocale(LC_ALL, 'fr_FR');

        view()->share('isNewsletter',true);
    }

    /**
     * Display the specified resource.
     * GET /stats/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $statistiques = [];
        $clickStats   = [];

        // Stats open, bounce etc.
        $campagne      = $this->campagne->find($id);
        $campagneStats = $this->worker->statsCampagne($campagne->api_campagne_id);

        if($campagneStats)
        {
            $statistiques  = $this->charts->compileStats($campagneStats);

            // Clicks
            $clickStats = $this->worker->clickStatistics($campagneStats['CampaignID'], 0);
        }

        return view('newsletter::Backend.stats.show')->with(
            [
                'isChart'      => true,
                'campagne'     => $campagne ,
                'statistiques' => $statistiques,
                'clickStats'   => $clickStats
            ]
        );
    }

    public function sumStatsClicksLinks($CampaignID, $offset = 0){

        $result = [];

        $data  = $this->worker->clickStatistics($CampaignID, $offset);
        $count = $this->statsworker->getTotalCount($data);

        if($count == 500)
        {
            $result[] = $data->Data;
            $offset   = $offset + 500;

            $result   = array_merge($result,$this->sumStatsClicksLinks($CampaignID, $offset));
        }
        else
        {
            $result[] = $data->Data;
        }

        return $result;
    }
}
