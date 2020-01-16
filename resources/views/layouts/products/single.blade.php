@extends('layouts.front')

@section('content')
<div class="album py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="row">
                    <div class="col-md-4">
                       <img class="card-img-top" src="{{asset('images/'.$product->thumbnail)}}" alt="Card image cap">
                    </div>
                    <div class="col-md-8">
                        <p class="card-title text-warning display-4">
                           {{ $product->title }}
                        </p>
                        <p class="card-text text-muted" style="font-size:20px;">
                          {!! $product->description !!}
                        </p>
                        <div class="d-block justify-content-between align-items-center">
                        <div class="btn-group">
                             <a href="{{route('products.addToCart',$product)}}" class="btn btn-sm btn-outline-secondary">Add to Cart</a>
                        </div>
                        <p class="text-muted">9 mins</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>

</div>

@endsection 



                