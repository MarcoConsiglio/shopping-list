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
            @if($product->measure != "null" && $product->measure != null)
              {{$product->measure}} {{number_format($product->quantity, 1, ",", ".")}}
            @else
              x{{intval($product->quantity)}}
            @endif
          </div>
          <div class="cart-quantity">
            @if($product->measure != "null" && $product->measure != null)
              {{$product->measure}} {{number_format($product->cart_quantity, 1, ",", ".")}}
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
        </div>
      </div>
    </div>
  </div><!-- .list-item -->
