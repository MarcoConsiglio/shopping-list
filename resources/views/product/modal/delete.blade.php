<div class="modal fade" id="deleteProductModal_{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalTitle_{{$product->id}}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteProductModalTitle_{{$product->id}}">Eliminare {{$product->name}}?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Annulla</button>
        <form method="POST" action="{{route("shopping_list.product.destroy", compact("shopping_list", "product"))}}">
            @csrf
            @method("DELETE")
            <button dusk="delete_product_button_modal_{{$product->id}}" type="submit" class="btn btn-danger text-white">Elimina</button>
        </form>
      </div>
    </div>
  </div>
</div>
