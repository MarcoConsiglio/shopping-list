@extends("layouts.standard")
@section("content")
<div class="container-fluid">
  <div class="row">
    <div class="col-xl-2"></div>
    <div class="col">

      <!-- Table header -->
      <div class="list-header-container col fixed-top mx-xl-auto py-2 d-flex flex-column justify-content-center text-center font-weight-bold bg-light rounded-bottom">
        <div class="d-flex flex-column justify-content-center mx-xl-auto w-100">
          <div class="d-md-flex">
            <div class="d-flex py-1 w-md-60 w-lg-40 justify-content-around">
              <div class="name">
                Nome
              </div>
              <div class="brand">
                Marca
              </div>
              <div class="price">
                Prezzo
              </div>
            </div>
            <div class="d-flex py-1 w-md-40 w-lg-60 justify-content-around">
              <div class="quantity">
               Quantità
              </div>
              <div class="cart-quantity">
                Nel carrello
              </div>
              <div class="note d-none d-lg-block">
                Nota
              </div>
            </div>
          </div>
          <div class="d-flex py-1 d-lg-none justify-content-center">
            <div class="note w-sm-50">
              Nota
            </div>
            <div class="header-extra-space d-none d-sm-block w-sm-50">

            </div>
          </div>
        </div>
      </div>
      <!-- End table header -->

      <!-- Table body -->
      <div class="list-extra-space">

      </div>
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      @if($shopping_list->products->count())
        @foreach ($shopping_list->products as $product)
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
                    € {{number_format($product->product->price, 2)}}
                  </div>
                </div>
                <div class="d-flex w-md-40 w-lg-60 justify-content-around py-1">
                  <div class="quantity">
                    {{$product->quantity}}
                  </div>
                  <div class="cart-quantity">
                    {{$product->cart_quantity}}
                  </div>
                  <div class="note d-none d-lg-block">
                    {{$product->note}}
                  </div>
                </div>
              </div>
              <div class="d-sm-flex mt-sm-2">
                <div class="note w-sm-50 d-lg-none">
                  <small>{{$product->note}}</small>
                </div>
                @include('product.buttons.actions')
              </div>
            </div>
          </div><!-- .list-item -->
        @endforeach

        <!-- End table body -->
      @else
        <div class="alert alert-secondary my-3">
          La lista è vuota.
        </div>
      @endif


    </div><!-- .col -->
    <div class="col-xl-2"></div>
  </div>
</div>
@endsection

