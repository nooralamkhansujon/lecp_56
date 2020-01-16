@extends('layouts.front')

@section('content')
  <h2 class="text-secondary">Shopping Cart Page</h2>
<table class="table table-striped">
    <thead class="bg-secondary text-light">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

    @if(isset($cart) && $cart->getContents())
        @foreach($cart->getContents() as $slug=>$product )
         
            <tr>
                <td>
                    <figure class="media">
                        <div class="img-wrap">
                        <img 
                          src="{{asset('images/'.$product['product']->thumbnail)}}" width="100" class="img-thumbnail img-sm" alt=""/>
                        </div>
                        <figcaption class="media-body ml-2">
                            <h6 class="title text-truncate text-success">
                            {{$product['product']->title}}
                            </h6>
                            <dl class="param param-inline small text-secondary">
                                <dt class="text-secondary">Size: </dt>
                                <dd>XXL</dd>
                            </dl>
                            <dl class="param param-inline small text-secondary">
                                <dt>Color: </dt>
                                <dd>Orange color</dd>
                            </dl>
                        </figcaption>
                    </figure>
                </td>
                <td>
                  <form action="{{route('cart.update',$slug)}}" method="POST">
                       @csrf 
                       <input type="number" name="qty" id="qty" 
                        class="form-control text-center" min="0" max="99" value="{{$product['qty']}}" />
                        <input type="submit" value="Update" class="btn btn-block btn-outline-success btn-round">
                  </form>
                  
                </td>
                <td>
                   <div class="price-wrap">
                      <span class="price">
                        USD {{ $product['price'] }}
                      </span>
                      <small class="text-muted">
                        (USD {{$product['product']->price}} EACH)
                      </small>
                   </div>
                </td>
                <td class="text-right">
                     <form action="{{route('cart.remove',$slug)}}" method="POST" accept-charset="utf-8">
                            @csrf 
                            <input type="submit" value="x Remove"  class="btn btn-outline-danger">
                     </form>
                </td>
            </tr>
         
        @endforeach 
        <tr>
           <th colspan="2" class="text-secondary">Total Qty: </th>
           <th colspan="2"  class="d-flex justify-content-end text-danger">
              {{$cart->getTotalQty()}}
           </th>
        </tr>

        <tr>
           <th colspan="2" class="text-secondary">Total Price: </th>
           <th colspan="2" class="d-flex justify-content-end text-danger">
              {{$cart->getTotalPrice()}}
            </th>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <div class="d-flex justify-content-between">
                       <a  href="{{route('checkout.index')}}" 
                        class="btn btn-outline-success" 
                      style="width:200px !important;">Stripe Checkout</a>

                      <a  href="{{route('checkout.paypalIndex')}}" 
                      class="btn btn-outline-success" 
                      style="width:200px !important;">PayPal Checkout</a>
                </div>
             
            </td>
        </tr>
       
    @else 
        <td colspan="4" class="alert alert-danger" style="font-weight:bold;" align="center">
          <p>No Cart Item Found 
            <a href="{{route('products.all')}}" class="ml-2">Buy Some Products</a>
          </p>
        </td>    
    @endif 
       
     </tbody>
</table>
@endsection 