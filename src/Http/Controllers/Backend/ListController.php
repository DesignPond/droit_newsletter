<?php

namespace designpond\newsletter\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use designpond\newsletter\Newsletter\Worker\ImportWorkerInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterListInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterEmailInterface;
use designpond\newsletter\Newsletter\Service\UploadInterface;
use designpond\newsletter\Http\Requests\ListRequest;
use designpond\newsletter\Http\Requests\SendListRequest;

class ListController extends Controller
{
    protected $list;
    protected $import;
    protected $emails;
    protected $upload;

    public function __construct( NewsletterListInterface $list, NewsletterEmailInterface $emails, ImportWorkerInterface $import, UploadInterface $upload )
    {
        $this->list     = $list;
        $this->emails   = $emails;
        $this->import   = $import;
        $this->upload   = $upload;

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
        $lists = $this->list->getAll();

        return view('newsletter::Backend.lists.import')->with(['lists' => $lists]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lists = $this->list->getAll();
        $list  = $this->list->find($id);

        return view('newsletter::Backend.lists.emails')->with(['lists' => $lists, 'list' => $list]);
    }

    /**
     * Send test campagne
     *
     * @return \Illuminate\Http\Response
     */
    public function send(SendListRequest $request)
    {
        $list = $this->list->find($request->input('list_id'));

        $this->import->send($request->input('campagne_id'),$list);

        alert()->success('Campagne envoyé à la liste!');

        return redirect('build/newsletter');
    }

    public function store(ListRequest $request)
    {
        $file = $this->upload->upload( $request->file('file') , 'files');

        if(!$file)
        {
            throw new \designpond\newsletter\Exceptions\FileUploadException('Upload failed');
        }

        // path to xls
        $path = public_path('files/'.$file['name']);

        // Read uploded xls
        $results = $this->import->read($path);

        if(isset($results) && $results->isEmpty() || !array_has($results->toArray(), '0.email') )
        {
            alert()->danger('Le fichier est vide ou mal formaté');

            return redirect()->back();
        }

        $emails  = $results->pluck('email')->all();
        $list    = $this->list->create(['title' => $request->input('title'), 'emails' => $emails]);

        alert()->success('Fichier importé!');

        return redirect('build/liste');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /list
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->list->delete($id);

        alert()->success('Liste supprimée');

        return redirect()->back();
    }
}
