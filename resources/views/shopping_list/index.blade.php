@extends('layouts.standard')
@section('content')
    <!-- Shopping List Modals -->
    @include("shopping_list.modal.create")
    @foreach($shopping_lists as $shopping_list)
        @include('shopping_list.modal.edit')
        @include('shopping_list.modal.delete')
    @endforeach
    <h4 class="text-center display-4">Le tue liste della spesa</h4>
    <div class="d-flex justify-content-around">
        <!-- ShoppingList Card -->
        @foreach($shopping_lists as $shopping_list)
        <div class="card shopping-list">
            <div class="card-body d-flex">
                <a href="{{route("shopping_list.show", $shopping_list)}}">
                    <h4 class="card-title text-truncate overflow-hidden" style="width: 160px">{{$shopping_list->title}}</h4>
                </a>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-around">
                    <a dusk="delete_button_{{$shopping_list->id}}" class="btn btn-danger text-white" href="#" role="button" data-toggle="modal" data-target="#delete_modal_{{$shopping_list->id}}">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <a dusk="edit_button_{{$shopping_list->id}}" class="pr-2 btn btn-warning text-white" href="#" role="button" data-toggle="modal" data-target="#edit_modal_{{$shopping_list->id}}">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @include("shopping_list.button.create")
@endsection
