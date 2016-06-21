@extends('newsletter::Backend.lists.index')
@section('list')
    @parent

    @if(isset($list))
    <div class="panel panel-primary">
        <div class="panel-body">

            <h4>{{ $list->title }} <button class="btn btn-xs btn-success pull-right" data-toggle="collapse" href="#addEmail" type="button"><i class="fa fa-plus"></i></button></h4>

            <div id="addEmail" class="row collapse">
                <div class="col-sm-12">
                    <form action="{{ url('build/emails') }}" method="POST">{!! csrf_field() !!}
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="email" class="form-control" placeholder="Ajouter un nouvel email">
                                <input type="hidden" name="list_id" value="{{ $list->id }}">
                                <span class="input-group-btn"><button class="btn btn-info" type="submit">Ajouter</button></span>
                            </div><!-- /input-group -->
                        </div>
                    </form>
                </div>
            </div>

            <br/>

            @if(!$list->emails->isEmpty())

                <table class="table">
                    <thead>
                    <tr>
                        <th class="col-sm-10">Email</th>
                        <th class="col-sm-2 no-sort"></th>
                    </tr>
                    </thead>
                    <tbody class="selects">
                        @foreach($list->emails as $email)
                            <tr>
                                <td>{{ $email->email }}</td>
                                <td class="text-right">
                                    <form action="{{ url('build/emails/'.$email->id) }}" method="POST">
                                        <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                                        <button data-what="Supprimer" data-action="{{ $email->email }}" class="btn btn-danger btn-xs pull-right deleteAction">x</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Aucun email dans cette liste</p>
            @endif
        </div>
    </div>
@endif

@endsection