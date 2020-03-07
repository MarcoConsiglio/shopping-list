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
                @lang('product.name')
              </div>
              <div class="brand">
                @lang('product.brand')
              </div>
              <div class="price">
                @lang('product.price')
              </div>
            </div>
            <div class="d-flex py-1 w-md-40 w-lg-60 justify-content-around">
              <div class="quantity">
                @lang('product.quantity')
              </div>
              <div class="cart-quantity">
                @lang('product.cart_quantity')
              </div>
              <div class="note d-none d-lg-block">
                @lang('product.note')
              </div>
            </div>
          </div>
          <div class="d-flex py-1 d-lg-none justify-content-center">
            <div class="note w-sm-50">
              @lang('product.note')
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

      {{-- @if($shopping_list->items->count())
        @foreach ($shopping_list->items as $item)
          <!-- List item -->
          <div class="list-item d-flex flex-column justify-content-center text-center border-bottom pt-2">
            <div class="d-flex flex-column justify-content-center" id="product_{{$item->product->id}}">
              <div class="d-md-flex justify-content-between">
                <div class="d-flex justify-content-around w-md-60 w-lg-40 py-1">
                  <div class="name font-weight-bold">
                    {{$item->product->name}}
                  </div>
                  <div class="brand">
                    {{$item->product->brand}}
                  </div>
                  <div class="price">
                    @if(App::isLocale('en'))
                      {{auth()->user()->settings->currency->symbol}} {{number_format($item->product->price, 2)}}
                    @elseif(App::isLocale('it'))
                      {{auth()->user()->settings->currency->symbol}} {{number_format($item->product->price, 2, ',', '.')}}
                    @endif
                  </div>
                </div>
                <div class="d-flex w-md-40 w-lg-60 justify-content-around py-1">
                  <div class="quantity">
                    {{$item->product->quantity}}
                  </div>
                  <div class="cart-quantity">
                    {{$item->product->cart_quantity}}
                  </div>
                  <div class="note d-none d-lg-block">
                    {{$item->product->note}}
                  </div>
                </div>
              </div>
              <div class="d-sm-flex mt-sm-2">
                <div class="note w-sm-50 d-lg-none">
                  <small>{{$item->product->note}}</small>
                </div>
                @include('product.buttons.actions')
              </div>
            </div>
          </div><!-- .list-item -->
        @endforeach --}}

        <!-- End table body -->
      {{-- @else
        <div class="alert alert-secondary my-3">
          @lang('product.no_products')
        </div>
      @endif --}}


    </div><!-- .col -->
    <div class="col-xl-2"></div>
  </div>
</div>


