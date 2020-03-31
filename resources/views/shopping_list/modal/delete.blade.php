<div class="modal fade" id="delete_modal_{{$shopping_list->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteShoppingList{{$shopping_list->id}}Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{route("shopping_list.destroy", $shopping_list)}}" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteShoppingList{{$shopping_list->id}}Label">Eliminare {{$shopping_list->title}}?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @csrf
        @method("DELETE")
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Chiudi</button>
          <button type="submit" class="btn btn-danger" dusk="delete_modal_button_{{$shopping_list->id}}">Elimina</button>
        </div>
      </form>
    </div>
  </div>
</div>
