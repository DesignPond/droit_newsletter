@extends('newsletter::Frontend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12 col-xs-12">

            <p><a href="{{ url('display/newsletter') }}"><i class="fa fa-arrow-circle-left"></i> Retour</a></p>
            <p><i class="fa fa-user"></i> &nbsp; {{ $newsletter->from_name }}</p>
            <p><i class="fa fa-envelope"></i> &nbsp; {{ $newsletter->from_email }}</p>

            <hr/>

            @if(!$newsletter->campagnes->isEmpty())
                <ul class="list-group">
                    @foreach($newsletter->campagnes as $campagne)
                        <a href="{{ url('display/newsletter/campagne/'.$campagne->id) }}" class="list-group-item {{ Request::is('display/newsletter/campagne/'.$campagne->id) ? 'active' : '' }}">{{ $campagne->sujet }}</a>
                    @endforeach
                </ul>
            @else
                <p>Encore aucune campagne</p>
            @endif

        </div>

    </div><!--END CONTENT-->

@stop
