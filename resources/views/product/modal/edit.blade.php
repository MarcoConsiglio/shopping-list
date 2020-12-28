<div class="modal fade" id="editProductModal_{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel_{{$product->id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProductModalLabel_{{$product->id}}">Modifica un prodotto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('shopping_list.product.update', [$shopping_list, $product])}}" method="POST" class="needs-validation" novalidate>
        <div class="modal-body">
          @csrf
          @method("PUT")
          <div class="form-group">
            <label for="name">Nome<span class="required">*</span></label>
            <input type="text" name="name" id="name" class="form-control" minlength="3" maxlength="50" value="{{null !== old('name') ? old('name') : $product->name}}" required>
            <div class="invalid-feedback">
              Inserisci il nome del prodotto, da 3 a 50 caratteri.
            </div>
          </div>
          <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" name="brand" id="brand" class="form-control" value="{{null !== old('brand') ? old('brand') : $product->brand}}" maxlength="50">
            <div class="invalid-feedback">
              La marca deve avere al massimo 50 caratteri.
            </div>
          </div>
          <div class="form-row d-flex justify-content-end">
            <div class="col-6">
              <label for="price">Prezzo</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">€</span>
                </div>
                <input name="price" id="price" type="number" min="0.00" max="1000.00" step="0.01" class="form-control rounded-right" value="{{null !== old('price') ? old('price') : $product->price}}"/>
                <div class="invalid-feedback">
                  Minimo 0, massimo 1000.
                </div>
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="quantity">Quantità</label>
                <input type="number" min="1" max="1000" @if(in_array($product->measure, ["kg", "l"])) step="0.5" @else step="1" @endif name="quantity" id="quantity" value="{{null !== old('quantity') ? old('quantity') : $product->quantity}}" class="form-control">
                <div class="invalid-feedback">
                  Minimo 0, massimo 1000.
                </div>
              </div>
            </div><!-- .col-3 -->
            <div class="col-3">
              <div class="form-group">
                <label for="measure">Misura</label>
                {{$measure = null !== old('measure') ? old('measure') : $product->measure}}
                <select id="measure" name="measure" class="form-control">
                  <option value=""      @if($measure == null)   selected @endif>Nessuna</option>
                  <option value="kg"    @if($measure == "kg")   selected @endif>kili</option>
                  <option value="l"     @if($measure == "l")    selected @endif>litri</option>
                  <option value="hg"    @if($measure == "hg")   selected @endif>etti</option>
                  <option value="g"     @if($measure == "g")    selected @endif>grammi</option>
                  <option value="ml"    @if($measure == "ml")   selected @endif>millilitri</option>
                </select>
              </div>
            </div><!-- .col-1 -->
          </div><!-- .form-row -->
          <div class="form-group">
            <label for="note">Nota</label>
            <textarea name="note" id="note" rows="3" placeholder="Altre informazioni" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Chiudi</button>
          <button type="submit" class="btn btn-warning text-white" dusk="update_product_{{$product->id}}_modal_button">Modifica</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
