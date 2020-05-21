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
        <button dusk="delete_product_button_modal_{{$product->id}}" type="button" class="btn btn-danger text-white">Elimina</button>
      </div>
    </div>
  </div>
</div>
