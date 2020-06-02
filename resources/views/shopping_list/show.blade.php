@extends("layouts.standard")
@section("content")
      <!-- Table header -->
      <div class="list-header-container mx-xl-auto py-2 d-flex flex-column justify-content-center text-center font-weight-bold bg-light rounded-bottom sticky-top">
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
          @include("product.show")
        @endforeach

        <!-- End table body -->
      @else
        <div class="alert alert-secondary my-3">
          La lista è vuota.
        </div>
      @endif
      @include("product.button.add")
      @include("product.modal.add")

      @foreach ($shopping_list->products as $product)
        @include("product.modal.delete")
        @include("product.modal.edit")
      @endforeach
@endsection

