@extends('newsletter::Backend.layouts.master')
@section('content')

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <h3 style="margin-bottom: 0;">Listes hors campagne</h3>
                </div>
                <div class="col-md-8 text-right">
                    <a href="{{ url('build/liste') }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp;Ajouter</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">

            <div class="panel panel-primary">
                <div class="panel-body">
                    @if(isset($lists) && !$lists->isEmpty())
                    <ul class="list-group list-group-import">
                        @foreach($lists as $list)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-9"><a href="{{ url('build/liste/'.$list->id) }}">{{ $list->title }}</a></div>
                                    <div class="col-md-2"><span class="label label-default pull-right">{{ $list->created_at->format('Y-m-d') }}</span></div>
                                    <div class="col-md-1">
                                        <form action="{{ url('build/liste/'.$list->id) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                                            <button data-what="supprimer" data-action="menu: {{ $list->title }}" class="btn btn-danger btn-xs pull-right deleteAction">x</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Contenu -->
            @yield('list')
            <!-- Fin contenu -->
        </div>
    </div>

@stop
