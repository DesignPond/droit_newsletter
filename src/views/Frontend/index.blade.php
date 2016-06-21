@extends('newsletter::Frontend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12 col-xs-12">

            <h2>Newsletter</h2>
            @if(!$newsletters->isEmpty())
                <ul class="list-group">
                    @foreach($newsletters as $newsletter)
                        <a href="{{ url('newsletter/'.$newsletter->id) }}" class="list-group-item {{ Request::is('newsletter/'.$newsletter->id) ? 'active' : '' }}">{{ $newsletter->titre }}</a>
                    @endforeach
                </ul>
            @else
                <p>Encore aucune newsletter</p>
            @endif

        </div>
    </div><!--END CONTENT-->

@stop
