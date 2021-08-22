@extends('layouts.standard')
@section('content')
    <div class="d-flex flex-column text-center">
        <img class="img-fluid mx-auto" style="width: 219px" src="{{asset('images/logo.png')}}">
        <div class="d-flex flex-row justify-content-center">
            <a class="btn btn-outline-primary" href="{{route("register")}}">{{__("Registrati")}}</a>
            <a class="btn btn-success ml-3" href="{{route("login")}}">{{__("Login")}}</a>
        </div>
        <cite>by Marco Consiglio</cite>
        <cite>v{{config("version")}}</cite>
    </div>
@endsection
