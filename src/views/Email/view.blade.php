@extends('newsletter::Email.layouts.master')
@section('content')

    @if(!$campagne->content->isEmpty())
        @foreach($campagne->content as $bloc)
            {!! view('newsletter::Email.send.'.$bloc->type->partial)->with(['bloc' => $bloc, 'campagne' => $campagne])->__toString() !!}
        @endforeach
    @endif

@stop