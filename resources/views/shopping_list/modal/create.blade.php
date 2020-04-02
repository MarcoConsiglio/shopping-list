<div class="modal" id="createModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="createShoppingListLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createShoppingListLabel">Crea lista della spesa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route("shopping_list.store")}}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" name="title" id="title" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Chiudi</button>
          <button type="submit" class="btn btn-success text-white" dusk="create_modal_button">Crea</button>
        </div>
      </form>
    </div>
  </div>
</div>
