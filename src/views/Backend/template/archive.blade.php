@extends('newsletter::Backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">
        <h3>Archive de {{ $newsletter->titre }}</h3>
        <p><a href="{{ url('build/newsletter') }}"><i class="fa fa-arrow-left"></i> retour</a></p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        @if($newsletter)

            <div class="panel panel-info">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4>Année {{ $year }}</h4>
                        </div>
                        <div class="col-md-10 text-right">
                            <div class="newsletter-archives">
                                <?php
                                    $years = $newsletter->sent->groupBy(function ($archive, $key) {
                                        return $archive->created_at->year;
                                    })->keys();
                                ?>
                                @foreach($years as $y)
                                    <a class="btn btn-primary btn-sm {{ $y == $year ? 'active' : '' }}" href="{{ url('build/newsletter/archive/'.$newsletter->id.'/'.$y) }}">Archives {{ $y }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            @if(!$campagnes->isEmpty())
                                @include('newsletter::Backend.campagne.list',['campagnes' => $campagnes])
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </div>
</div>

@stop
