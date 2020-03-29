<!-- Edit ShoppingList -->
<div class="modal fade" id="edit_modal_{{$shopping_list->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modifica {{$shopping_list->title}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route("shopping_list.update", $shopping_list)}}" method="POST">
            @csrf
            @method('PUT')
          <div class="modal-body">
            <div class="form-group">
              <label for="title">Titolo</label>
              <input
                value="{{$shopping_list->title}}"
                type="text"
                name="title"
                id="title"
                class="form-control"
                required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Chiudi</button>
            <button dusk="edit_modal_button_{{$shopping_list->id}}" type="submit" class="btn btn-warning text-white">Modifica</button>
          </div>
        </form>
      </div>
    </div>
  </div>
