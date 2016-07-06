<?php

namespace designpond\newsletter\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use designpond\newsletter\Http\Requests\CopyRequest;
use designpond\newsletter\Http\Requests\PasteRequest;
use designpond\newsletter\Newsletter\Repo\NewsletterClipboardInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterContentInterface;

class ClipboardController extends Controller
{
    protected $clipboard;
    protected $content;

    public function __construct(NewsletterClipboardInterface $clipboard, NewsletterContentInterface $content)
    {
        $this->clipboard = $clipboard;
        $this->content   = $content;
    }

    public function copy(CopyRequest $request)
    {
        $this->clipboard->create($request->all());

        return redirect()->back()->with(['status' => 'success', 'message' => 'Contenu copié dans le presse papier']);
    }

    public function paste(PasteRequest $request)
    {
        $copy      = $this->clipboard->find($request->input('id'));
        $content   = $this->content->find($copy->content_id);
        $replicate = $content->replicate();

        $replicate->newsletter_campagne_id = $request->input('campagne_id');
        $replicate->rang = $request->input('rang', 0) + 1;
        $replicate->save();

        $copy->delete();

        return redirect()->back()->with(['status' => 'success', 'message' => 'Contenu collé dans la campagne']);
    }
}
