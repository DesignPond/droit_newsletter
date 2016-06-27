@extends('newsletter::Frontend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12 col-xs-12">

            <p><a href="{{ url('display/newsletter/'.$campagne->newsletter_id ) }}"><i class="fa fa-arrow-circle-left"></i> Retour</a></p>
            <h2>{{ $campagne->sujet }}</h2>
            <h3>{{ $campagne->auteurs }}</h3>

            <hr/>

            @if(!$campagne->content->isEmpty())
                @foreach($campagne->content as $bloc)
                    {!! view('newsletter::Frontend.content.'.$bloc->type->partial)->with(['bloc' => $bloc ])->__toString() !!}
                @endforeach
            @endif

        </div>

    </div><!--END CONTENT-->

@stop
