<?php

namespace designpond\newsletter\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use designpond\newsletter\Http\Requests\ImportRequest;
use designpond\newsletter\Newsletter\Repo\NewsletterInterface;
use designpond\newsletter\Newsletter\Worker\ImportWorkerInterface;

class ImportController extends Controller
{
    protected $newsletter;
    protected $worker;

    public function __construct( NewsletterInterface $newsletter, ImportWorkerInterface $worker )
    {
        $this->newsletter = $newsletter;
        $this->worker     = $worker;
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

        return view('newsletter::Backend.import')->with(['newsletters' => $newsletters]);
    }

    public function store(ImportRequest $request)
    {
        $data = $request->all();
        $file = $request->file('file');

        $this->worker->import($data,$file);

        return redirect('build/import')->with(['status' => 'success', 'message' => 'Fichier importé!']);
    }
}
