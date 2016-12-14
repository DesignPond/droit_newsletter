@extends('newsletter::Frontend.layouts.print')
@section('content')

    <div class="row">
        <div style="background: #f5f5f5; margin-bottom: 30px; padding: 10px;">
            <h1 style="font-size: 25px; margin-bottom: 5px; line-height: 20px;">Newsletter {{ config('app.name') }}</h1>
            <h2 style="font-size: 22px; margin-bottom: 5px; line-height: 20px;">{{ $campagne->sujet }}</h2>
            <h3 style="font-size: 18px; margin-bottom: 0px; line-height: 20px;">{{ $campagne->auteurs }}</h3>
        </div>
    </div><!--END CONTENT-->
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">

            @if(!$campagne->content->isEmpty())
                @foreach($campagne->content as $bloc)
                    <div class="bloc">
                        {!! view('newsletter::Frontend.print.'.$bloc->type->partial)->with(['bloc' => $bloc ])->__toString() !!}
                    </div>
                @endforeach
            @endif

        </div>
    </div><!--END CONTENT-->


@stop