<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Aggiungi un prodotto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('shopping_list.product.store', compact('shopping_list'))}}" method="POST" class="needs-validation" novalidate>
        <div class="modal-body">
          @csrf
          <div class="form-group">
            <label for="name">Nome<span class="required">*</span></label>
            <input type="text" name="name" id="name" class="form-control" minlength="3" maxlength="50" required>
            <div class="invalid-feedback">
              Inserisci il nome del prodotto, da 3 a 50 caratteri.
            </div>
          </div>
          <div class="form-group">
            <label for="brand">Marca</label>
            <input type="text" name="brand" id="brand" class="form-control" maxlength="50">
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
                <input name="price" id="price" type="number" min="0.00" max="1000.00" step="0.01" value="0.00" class="form-control rounded-right"/>
                <div class="invalid-feedback">
                  Minimo 0, massimo 1000.
                </div>
              </div>
            </div>
            <div class="col-3">
              <div class="form-group">
                <label for="quantity">Quantità</label>
                <input type="number" min="1" max="1000" @if(in_array($product->measure, ["kg", "l"])) step="0.5" @else step="1" @endif name="quantity" id="quantity" value="1" class="form-control">
                <div class="invalid-feedback">
                  Minimo 0, massimo 1000.
                </div>
              </div>
            </div><!-- .col-3 -->
            <div class="col-3">
              <div class="form-group">
                <label for="measure">Misura</label>
                <select id="measure" name="measure" class="form-control">
                  <option value="" selected>Nessuna</option>
                  <option value="kg">kili</option>
                  <option value="l">litri</option>
                  <option value="hg">etti</option>
                  <option value="g">grammi</option>
                  <option value="ml">millilitri</option>
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
          <button type="submit" class="btn btn-success" dusk="add_product_modal_button">Aggiungi</button>
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
