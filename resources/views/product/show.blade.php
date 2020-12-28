<!-- List item -->
<div class="list-item d-flex flex-column justify-content-center text-center border-bottom pt-2">
    <div class="d-flex flex-column justify-content-center" id="product_{{$product->id}}">
      <div class="d-md-flex justify-content-between">
        <div class="d-flex justify-content-around w-md-60 w-lg-40 py-1">
          <div class="name font-weight-bold">
            {{$product->name}}
          </div>
          <div class="brand">
            {{$product->brand}}
          </div>
          <div class="price">
            € {{number_format($product->price, 2, ",", ".")}}
          </div>
        </div>
        <div class="d-flex w-md-40 w-lg-60 justify-content-around py-1">
          <div class="quantity">
            @if($product->measure)
            {{
                round($product->quantity) == $product->quantity ?
                number_format($product->quantity, 0, ",", ".") :
                number_format($product->quantity, 1, ",", ".")
            }} {{$product->measure == "hg" ? "etti" : $product->measure}}
            @else
              x{{intval($product->quantity)}}
            @endif
          </div>
          <div class="cart-quantity" dusk="cartQuantity_{{$product->id}}">
            @if($product->measure)
            {{
                round($product->cart_quantity) == $product->cart_quantity ?
                number_format($product->cart_quantity, 0, ",", ".") :
                number_format($product->cart_quantity, 1, ",", ".")
            }} {{$product->measure == "hg" ? "etti" : $product->measure}}
            @else
              x{{intval($product->cart_quantity)}}
            @endif
          </div>
          <div class="note d-none d-lg-block">
            <small>{{$product->note}}</small>
          </div>
        </div>
      </div>
      <div class="d-sm-flex mt-sm-2">
        <div class="note w-sm-50 d-lg-none">
          <small>{{$product->note}}</small>
        </div>
        <div class="my-2 mx-lg-auto w-sm-50 w-lg-40 d-flex justify-content-around justify-content-sm-center justify-content-lg-around">
            @include("product.button.delete")
            @include("product.button.edit")
            @include("product.button.add_to_cart")
        </div>
      </div>
    </div>
  </div><!-- .list-item -->
