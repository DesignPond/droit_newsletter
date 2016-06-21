<?php

namespace designpond\newsletter\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use designpond\newsletter\Newsletter\Repo\NewsletterListInterface;
use designpond\newsletter\Newsletter\Repo\NewsletterEmailInterface;
use designpond\newsletter\Http\Requests\EmailRequest;

class EmailController extends Controller
{
    protected $list;
    protected $emails;

    public function __construct( NewsletterListInterface $list, NewsletterEmailInterface $emails)
    {
        $this->list     = $list;
        $this->emails   = $emails;

        setlocale(LC_ALL, 'fr_FR.UTF-8');
        view()->share('isNewsletter',true);
    }

    public function store(Request $request)
    {
        $email = $this->emails->create( $request->all() );

        return redirect('build/liste/'.$email->list_id)->with(['status' => 'success', 'message' => 'Email ajouté']);
    }

    /**
     * Update the specified resource in storage.
     * PUT /compte/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        $email = $this->emails->update( $request->all() );

        return redirect('build/liste/'.$email->list_id)->with(['status' => 'success' , 'message' => 'Email mis à jour']);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /list
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->emails->delete($id);

        return redirect()->back()->with(['status' => 'success', 'message' => 'Email supprimée de la liste']);
    }
}
