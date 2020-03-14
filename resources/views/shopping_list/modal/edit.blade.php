<!-- Edit ShoppingList -->
<div class="modal fade" id="edit_modal_{{$shopping_list->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit {{$shopping_list->name}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route("shopping_list.update")}}">
            <div class="modal-body">
              <div class="form-group">
                  <label for="title">Title</label>
                  <input type="text" name="title" id="title" class="form-group" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger text-white">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>
