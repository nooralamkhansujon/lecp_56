

<div class="album py-5 bg-light">
   <div class="container">

    <div class="row">

        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                <img class="card-img-top" src="{{asset('images/'.$product->thumbnail)}}" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-title text-danger">{{ $product->title }}</p>
                        <p class="card-text text-muted">
                        {!! $product->description !!}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            <a href="{{route('products.single',$product)}}"    class="btn btn-sm btn-outline-secondary">View Product</a>
                            <a href="{{route('products.addToCart',$product)}}" class="btn btn-sm btn-outline-secondary">Add to Cart</a>
                        </div>
                        <small class="text-muted">9 mins</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach        

    </div>

      <div class="row">
        <div class="col-md-12">
           {{ $products->links() }}
        </div>
      </div>
    </div>
</div>


