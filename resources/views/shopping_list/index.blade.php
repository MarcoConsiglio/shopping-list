@extends('layouts.standard')
@section('content')
<h3 class="text-center display-4"></h3>
@foreach ($shopping_lists as $shopping_list)
<a href="{{route("shopping_list.show", $shopping_list)}}">
    <div class="card shopping-list">
        <div class="card-body">
            <h4 class="card-title">{{$shopping_list->title}}</h4>
        </div>
    </div>
</a>
@endforeach
@endsection
