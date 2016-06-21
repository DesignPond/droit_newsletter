@extends('newsletter::Backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="options" style="margin-bottom: 10px;">
            <a href="{{ url('build/subscriber') }}" class="btn btn-inverse"><i class="fa fa-chevron-left"></i> &nbsp;Retour aux abonnés</a>
        </div>
        <div class="panel panel-info">

            <!-- form start -->
            <form action="{{ url('build/subscriber') }}" method="POST" class="validate-form form-horizontal">
                {!! csrf_field() !!}

                <div class="panel-body">
                    <h4>Ajouter un abonné</h4>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">email</label>
                        <div class="col-sm-6">
                            <input type="text" required class="form-control" name="email" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Abonnements</label>
                        <div class="col-sm-6">
                            @if(!$newsletter->isEmpty())
                                @foreach($newsletter as $abonnement)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="newsletter_id[]" value="{{ $abonnement->id }}">{{ $abonnement->titre }}
                                    </label>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <button class="btn btn-primary" type="submit">Envoyer</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

@stop
