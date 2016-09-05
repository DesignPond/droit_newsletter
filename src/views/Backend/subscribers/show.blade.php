@extends('newsletter::Backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <div class="options" style="margin-bottom: 10px;">
            <a href="{{ url('build/subscriber') }}" class="btn btn-inverse"><i class="fa fa-chevron-left"></i> &nbsp;Retour aux abonnés</a>
        </div>

        <div class="panel panel-info">

            <form action="{{ url('build/subscriber/'.$subscriber->id) }}" method="POST" class="validate-form form-horizontal">
                <input type="hidden" name="_method" value="PUT">{!! csrf_field() !!}
                <div class="panel-body">
                    <h4>&Eacute;diter un abonné</h4>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="email" value="{{ $subscriber->email  }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-6">
                           <select class="form-control" name="activation">
                               <option {{ !$subscriber->activated_at ? 'selected' : '' }} value="0">Non confirmé</option>
                               <option {{ $subscriber->activated_at ? 'selected' : '' }} value="1">Confirmé</option>
                           </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Abonnements</label>
                        <div class="col-sm-6">

                            <?php $abos = (!$subscriber->subscriptions->isEmpty() ? $subscriber->subscriptions->pluck('id')->all() : []);?>

                            @if(!$newsletter->isEmpty())
                                @foreach($newsletter as $abonnement)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="newsletter_id[]" <?php if(in_array($abonnement->id,$abos)){ echo 'checked'; } ?> value="{{ $abonnement->id }}">
                                            {{ $abonnement->titre }}
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
                            <input type="hidden" name="id" value="{{ $subscriber->id  }}">
                            <button class="btn btn-primary" type="submit">Envoyer</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

@stop
