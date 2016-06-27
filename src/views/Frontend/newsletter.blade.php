@extends('Frontend.layouts.master')
@section('content')

<div class="row">
    <div class="col-xs-12">

        <h2>Newsletter</h2>
        <h3>{{ $newsletter->titre }}</h3>

        <hr/>

        @if(!$newsletter->campagnes->isEmpty())
            <ul class="list-group">
                @foreach($newsletter->campagnes as $campagne)
                    @if($campagne->status == 'envoyé')
                        <a href="{{ url('display/newsletter/campagne/'.$campagne->id) }}" class="list-group-item">{{ $campagne->sujet }}</a>
                    @endif
                @endforeach
            </ul>
        @else
            <p>Encore aucune campagne</p>
        @endif
    </div>

</div><!--END CONTENT-->

@stop
