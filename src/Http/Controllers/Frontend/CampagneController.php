<?php

namespace Designpond\Newsletter\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use designpond\newsletter\Newsletter\Repo\NewsletterCampagneInterface;

class CampagneController extends Controller
{
    protected $campagne;

    public function __construct(NewsletterCampagneInterface $campagne)
    {
        $this->campagne = $campagne;
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campagne = $this->campagne->find($id);

        return view('newsletter::Email.view')->with(['campagne' => $campagne]);
    }

    public function pdf($id)
    {
        $campagne = $this->campagne->find($id);

        $pdf = \PDF::loadView('newsletter::Frontend.pdf', ['campagne' => $campagne])->setPaper('a4');

       // $pdf->set_option('defaultFont', 'Arial');

        return $pdf->stream('newsletter_'.$id.'.pdf');
    }

}
