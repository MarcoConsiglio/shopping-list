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
        <ul class="list-group list-group-flush">
        @foreach($shopping_lists as $shopping_list)
            <li class="list-group-item mb-3 shadow-sm rounded">
                <a dusk="shopping_list_{{$shopping_list->id}}" href="{{route("shopping_list.show", $shopping_list)}}">
                    <h4 class="text-truncate overflow-hidden">{{$shopping_list->title}}</h4>
                </a>
                <div class="d-flex justify-content-end">
                    <a dusk="delete_button_{{$shopping_list->id}}" class="btn btn-danger text-white mx-2 shadow-sm" href="#" role="button" data-toggle="modal" data-target="#delete_modal_{{$shopping_list->id}}">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                    <a dusk="edit_button_{{$shopping_list->id}}" class="pr-2 btn btn-warning text-white mx-2 shadow-sm  " href="#" role="button" data-toggle="modal" data-target="#edit_modal_{{$shopping_list->id}}">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </li>
        {{-- <div>

            <div class="d-flex justify-content-around">
                <a dusk="delete_button_{{$shopping_list->id}}" class="btn btn-danger text-white" href="#" role="button" data-toggle="modal" data-target="#delete_modal_{{$shopping_list->id}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <a dusk="edit_button_{{$shopping_list->id}}" class="pr-2 btn btn-warning text-white" href="#" role="button" data-toggle="modal" data-target="#edit_modal_{{$shopping_list->id}}">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div> --}}
        @endforeach
        </ul><!-- .list-group .list-group-flush -->
    </div>
    @include("shopping_list.button.create")
@endsection
