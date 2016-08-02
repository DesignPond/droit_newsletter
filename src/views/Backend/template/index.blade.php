@extends('newsletter::Backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-6">
        <h3>Liste des newsletter</h3>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{ url('build/newsletter/create') }}" class="btn btn-success" id="addNewsletter"><i class="fa fa-plus"></i> &nbsp;Newsletter</a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        @if(!$newsletters->isEmpty())
            @foreach($newsletters as $newsletter)

                <div class="panel panel-info">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-7">
                                <h3>{{ $newsletter->titre }}</h3>
                            </div>
                            <div class="col-md-3">
                                <p><i class="fa fa-user"></i> &nbsp; {{ $newsletter->from_name }}</p>
                                <p><i class="fa fa-envelope"></i> &nbsp; {{ $newsletter->from_email }}</p>
                            </div>
                            <div class="col-md-2 text-right">
                                <div class="btn-group-vertical" role="group">
                                    <a href="{{ url('build/newsletter/'.$newsletter->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> &nbsp;Editer</a>
                                    <a href="{{ url('build/campagne/create/'.$newsletter->id) }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> &nbsp;Campagne</a>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                @if(!$newsletter->campagnes->isEmpty())

                                    <?php
                                        $years     = $newsletter->sent->groupBy(function ($archive, $key) {
                                            return $archive->created_at->year;
                                        })->keys();
                                    ?>

                                    <h4>Brouillons</h4>
                                    @include('newsletter::Backend.campagne.list',['campagnes' => $newsletter->draft])

                                    <h4>En attente d'envoi</h4>
                                    @include('newsletter::Backend.campagne.list',['campagnes' => $newsletter->pending])

                                    <hr/>
                                    <div class="newsletter-archives">
                                        @foreach($years as $year)
                                            <a class="btn btn-primary btn-sm" href="{{ url('build/newsletter/archive/'.$newsletter->id.'/'.$year) }}">Archives {{ $year }}</a>
                                        @endforeach
                                    </div>

                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <form action="{{ url('build/newsletter/'.$newsletter->id) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                                    <button data-what="supprimer" data-action="newsletter {{ $newsletter->titre }}" class="btn btn-xs btn-danger btn-delete deleteNewsAction">Supprimer la newsletter</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            @endforeach
        @endif

    </div>
</div>

@stop
