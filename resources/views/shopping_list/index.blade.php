@extends('layouts.standard')
@section('content')
    <h4 class="text-center display-4">Le tue liste della spesa</h4>
    <div class="d-flex">
        <!-- ShoppingList Card -->
        @foreach($shopping_lists as $shopping_list)
        <div class="card shopping-list">
            <a href="{{route('shopping_list.show', $shopping_list)}}">
                <div class="card-body">
                    <h4 class="card-title">{{$shopping_list->title}}</h4>
                </div>
            </a>
            <div class="card-footer d-flex">
                <a dusk="edit_button_{{$shopping_list->id}}" class="pr-2 btn btn-warning text-white" href="#" role="button" data-toggle="modal" data-target="#edit_modal_{{$shopping_list->id}}">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
        @endforeach

        <!-- ShoppingList Edit Modals -->
        @foreach($shopping_lists as $shopping_list)
            @include('shopping_list.modal.edit')
        @endforeach
    </div>
@endsection
