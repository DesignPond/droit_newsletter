<?php

namespace designpond\newsletter\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use designpond\newsletter\Newsletter\Repo\NewsletterInterface;
use designpond\newsletter\Newsletter\Service\UploadWorker;
use designpond\newsletter\Newsletter\Worker\MailjetInterface;

class NewsletterController extends Controller
{
    protected $newsletter;
    protected $upload;
    protected $mailjet;

    public function __construct(NewsletterInterface $newsletter, UploadWorker $upload, MailjetInterface $mailjet )
    {
        $this->newsletter = $newsletter;
        $this->upload     = $upload;
        $this->mailjet    = $mailjet;

        setlocale(LC_ALL, 'fr_FR.UTF-8');

        view()->share('isNewsletter',true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newsletters = $this->newsletter->getAll();

        return view('newsletter::Backend.template.index')->with(['newsletters' => $newsletters]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newsletter::Backend.template.create')->with(['lists' => $lists]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('logos','header','soutien');

        if(!empty($request->file('logos'))){
            $logos = $this->upload->upload($request->file('logos'), 'newsletter');
            $data['logos'] = isset($logos['name']) ?  $logos['name'] : null;
        }

        if(!empty($request->file('header'))){
            $header = $this->upload->upload($request->file('header'), 'newsletter');
            $data['header'] = isset($header['name']) ? $header['name'] : null;
        }

        if(!empty($request->file('soutien'))){
            $soutien = $this->upload->upload($request->file('soutien'), 'newsletter');
            $data['soutien'] = isset($soutien['name']) ? $soutien['name'] : null;
        }

        $newsletter = $this->newsletter->create($data);

        return redirect('build/newsletter/'.$newsletter->id)->with(['status' => 'success', 'message' => 'Newsletter crée']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lists      = $this->mailjet->getAllLists();
        $lists      = (isset($lists->Data) ? $lists->Data : []);
        $newsletter = $this->newsletter->find($id);

        return view('newsletter::Backend.template.show')->with(['newsletter' => $newsletter, 'lists' => $lists]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('logos','header','soutien');

        if(!empty($request->file('logos'))){
            $logos = $this->upload->upload($request->file('logos'), 'newsletter');
            $data['logos'] = isset($logos['name']) ?  $logos['name'] : null;
        }
        
        if(!empty($request->file('header'))){
            $header = $this->upload->upload($request->file('header'), 'newsletter');
            $data['header'] = isset($header['name']) ? $header['name'] : null; 
        }
        
        if(!empty($request->file('soutien'))){
            $soutien = $this->upload->upload($request->file('soutien'), 'newsletter');
            $data['soutien'] = isset($soutien['name']) ? $soutien['name'] : null; 
        }

        $newsletter = $this->newsletter->update($data);

        return redirect('build/newsletter/'.$newsletter->id)->with(['status' => 'success', 'message' => 'Newsletter édité']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->newsletter->delete($id);

        return redirect()->back()->with(['status' => 'success', 'message' => 'Newsletter supprimée']);
    }
}
