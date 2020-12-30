@extends('layouts.standard')
@section('content')
    <div class="d-flex flex-column text-center">
        <img class="img-fluid mx-auto" style="width: 219px" src="{{asset('images/logo.png')}}">
        <cite>by Marco Consiglio</cite>
        <cite>v{{config("version")}}</cite>
    </div>
@endsection
