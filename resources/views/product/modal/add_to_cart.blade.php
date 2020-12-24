<div class="modal fade" id="addToCart_{{$product->id}}" tabindex="-1" aria-labelledby="addToCartModalLabel_{{$product->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToCartModalLabel_{{$product->id}}">Quanti ne vuoi mettere nel carrello?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route("shopping_list.product.add_to_cart", compact("shopping_list", "product"))}}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="sr-only" for="cart_quantity_{{$product->id}}">Quantità nel carrello</label>
                    @if($product->measure)
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">{{$product->measure === "hg" ? "etti" : $product->measure}}</div>
                            </div>
                            <input type="number" class="form-control" name="cart_quantity" id="cart_quantity_{{$product->id}}" value="{{$product->quantity}}"  @if(in_array($product->measure, ["kg", "l"])) step="0.5" @else step="1" @endif>
                        </div>
                    @else
                        <input type="number" class="form-control" name="cart_quantity" id="cart_quantity_{{$product->id}}" value="{{$product->quantity}}" step="1">
                    @endif
                </div><!-- .modal-body" -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Chiudi</button>
                    <button type="submit" class="btn btn-success" dusk="confirm_add_to_cart_{{$product->id}}">Aggiungi</button>
                </div><!-- .modal-footer" -->
            </form>
        </div><!-- .modal-content" -->
    </div><!-- .modal-dialog" -->
</div><!-- .modal -->
