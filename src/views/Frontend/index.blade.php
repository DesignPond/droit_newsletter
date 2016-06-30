@extends('newsletter::Frontend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12 col-xs-12">

            <h2>Newsletter</h2>
            @if(!$newsletters->isEmpty())
                <ul class="list-group">
                    @foreach($newsletters as $newsletter)
                        <a href="{{ url('display/newsletter/'.$newsletter->id) }}" class="list-group-item {{ Request::is('display/newsletter/'.$newsletter->id) ? 'active' : '' }}">{{ $newsletter->titre }}</a>
                    @endforeach
                </ul>
            @else
                <p>Encore aucune newsletter</p>
            @endif

        </div>
    </div><!--END CONTENT-->

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <h2>Subscribe</h2>
            @if(!$newsletters->isEmpty())
                @foreach($newsletters as $newsletter)
                    <h4>{{ $newsletter->titre }}</h4>
                    @include('newsletter::Frontend.partials.subscribe', ['newsletter' => $newsletter])
                @endforeach
            @endif
        </div>
    </div><!--END CONTENT-->

    <div class="row">
        <div class="col-md-12 col-xs-12">
            <h2>Unsubscribe</h2>
            @if(!$newsletters->isEmpty())
                @foreach($newsletters as $newsletter)
                    <h4>{{ $newsletter->titre }}</h4>
                    @include('newsletter::Frontend.partials.unsubscribe', ['newsletter' => $newsletter])
                @endforeach
            @endif
        </div>
    </div><!--END CONTENT-->
@stop
