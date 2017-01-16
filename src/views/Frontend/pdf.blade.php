@extends('newsletter::Frontend.layouts.print')
@section('content')

    <div class="header">
        <h1 style="font-size: 21px; margin: 5px 0 5px 0; line-height: 20px;">Newsletter {{ config('app.name') }}</h1>
        <h2 style="font-size: 18px; margin: 0 0 5px 0; line-height: 20px;">{{ $campagne->sujet }}</h2>
        <h3 style="font-size: 15px; margin: 0; line-height: 20px;">{{ $campagne->auteurs }}</h3>
    </div>

    @if(!$campagne->content->isEmpty())
        @foreach($campagne->content as $bloc)
            <div class="bloc">
                {!! view('newsletter::Frontend.print.'.$bloc->type->partial)->with(['bloc' => $bloc , 'campagne' => $campagne])->__toString() !!}
            </div>
        @endforeach
    @endif

@stop