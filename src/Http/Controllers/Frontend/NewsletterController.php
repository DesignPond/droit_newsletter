<?php

namespace Designpond\Newsletter\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use designpond\newsletter\Newsletter\Repo\NewsletterInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface;
use designpond\newsletter\Newsletter\Worker\CampagneInterface;

class NewsletterController extends Controller
{
    protected $newsletter;
    protected $campagne;
    protected $worker;

    public function __construct(NewsletterInterface $newsletter, NewsletterCampagneInterface $campagne, CampagneInterface $worker)
    {
        $this->campagne   = $campagne;
        $this->worker     = $worker;
        $this->newsletter = $newsletter;

        setlocale(LC_ALL, 'fr_FR.UTF-8');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsletters = $this->newsletter->getAll();
        
        return view('newsletter::Frontend.index')->with(['newsletters' => $newsletters]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newsletter = $this->newsletter->find($id);
        
        return view('newsletter::Frontend.show')->with(['newsletter' => $newsletter]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function campagne($id)
    {
        $campagne = $this->campagne->find($id);

        return view('newsletter::Frontend.campagne')->with(['campagne' => $campagne]);
    }
    
}
