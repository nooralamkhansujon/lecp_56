@extends('layouts.front')

@section('content')

<div class="row">
    <div class="col-md-4 order-md-2 mb-4 mt-2">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-success">Your cart</span>
        <span class="badge badge-secondary badge-pill">
          {{@$cart->getTotalQty()}}
        </span>
      </h4>
      <ul class="list-group mb-3">
        
        @foreach($cart->getContents() as $slug => $product)
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                  <h6 class="my-0 text-success">
                    {{ $product['product']->title }}
                  </h6>
                  <small class="text-success">
                    Quantity: {!! $product['qty'] !!}
                  </small>
              </div>
              <span class="text-danger">
                <strong>$</strong>
                {{ $product['price'] }}
              </span>
            </li>
        @endforeach 

        <li class="list-group-item d-flex justify-content-between">
            <span class="text-success">Total (USD)</span>
            <strong class="text-danger">$
              {{ $cart->getTotalPrice() }}
            </strong>
        </li> 

      </ul>
    </div>

    <div class="col-md-8 order-md-1 mt-2">
      <h4 class="mb-3 text-success">Billing address</h4>
      <form class="needs-validation" id="payment-form" 
      action="{{route('checkout.paypal')}}" method="POST">
            @csrf 
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstName">First name</label>
                    <input type="text" class="form-control" id="billing_firstName" name="billing_firstName">
                  @if($errors->has('billing_firstName'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_firstName')}}
                      </div>
                   @endif 
                </div>
                <div class="col-md-6 mb-3">
                    <label for="lastName">Last name</label>
                    <input type="text" class="form-control" id="billing_lastName" name="billing_lastName" >
                    @if($errors->has('billing_lastName'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_lastName')}}
                      </div>
                   @endif 
                </div>

                <div class="col-md-12 mb-3">
                    <label for="lastName">Username</label>
                    <input type="text" class="form-control" id="username" name="username" >
                    @if($errors->has('username'))
                      <div class="alert alert-danger">
                        {{$errors->first('username')}}
                      </div>
                   @endif 
                </div>
            </div>

           

            <div class="mb-3">
                <label for="email">Email <span class="text-muted">(Optional)</span></label>
                <input type="email" name="email" class="form-control" id="email" placeholder="you@example.com">
                @if($errors->has('email'))
                    <div class="alert alert-danger">
                      {{$errors->first('email')}}
                    </div>
               @endif 
            </div>

            <div class="mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="billing_address1" id="billing_address1" placeholder="1234 Main St">
                @if($errors->has('billing_address1'))
                    <div class="alert alert-danger">
                      {{$errors->first('billing_address1')}}
                    </div>
               @endif
            </div>

            <div class="mb-3">
                <label for="address2">Address Line 2 <span class="text-muted">(Optional)</span></label>
                <input type="text" name="billing_address2" class="form-control" id="billing_address2" placeholder="Apartment or suite">
                @if($errors->has('billing_address2'))
                    <div class="alert alert-danger">
                      {{$errors->first('billing_address2')}}
                    </div>
               @endif 
            </div>

            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="country">Country</label>
                    <select class="custom-select d-block w-100" id="billing_country" name="billing_country">
                        <option value="">Choose...</option>
                        <option>United States</option>
                    </select>
                    @if($errors->has('billing_country'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_country')}}
                      </div>
                   @endif 
                </div>
                <div class="col-md-4 mb-3">
                    <label for="state">State</label>
                    <select class="custom-select d-block w-100" name="billing_state" id="billing_state">
                        <option value="">Choose...</option>
                        <option>California</option>
                    </select>
                    @if($errors->has('billing_state'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_state')}}
                      </div>
                   @endif 
                </div>
                <div class="col-md-3 mb-3">
                    <label for="billing_zip">Zip</label>
                    <input type="text" name="billing_zip" class="form-control" id="billing_zip" >
                    @if($errors->has('billing_zip'))
                      <div class="alert alert-danger">
                        {{$errors->first('billing_zip')}}
                      </div>
                   @endif 
                </div>
            
        </div>
    
        <hr class="mb-4">
        <div class="custom-control custom-checkbox">
          <input name="shipping_address"  type="checkbox" class="custom-control-input" id="same-address">
          <label class="custom-control-label" for="same-address">
             Shipping address is the same as my billing address
          </label>
        </div>
        <div class="custom-control custom-checkbox">
          <input type="checkbox" class="custom-control-input" id="save-info">
          <label class="custom-control-label" for="save-info">
          Checkout As Guest
          </label>
        </div>

    
    <div id="shipping_address">
      <hr class="mb-4">
      <h4 class="mb-3">Shipping Address</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="firstName">First name</label>
                    <input type="text" class="form-control" name="shipping_firstName" id="shipping_firstName">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="shipping_lastName">Last name</label>
                    <input type="text" class="form-control" name="shipping_lastName" id="shipping_lastName">
                </div>
               
            </div>

            <div class="mb-3">
                <label for="shipping_address">Address</label>
                <input type="text" class="form-control" id="shipping_address1"  name="shipping_address1" placeholder="1234 Main St">
            </div>

            <div class="mb-3">
              <label for="shipping_address2">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" name="shipping_address2" id="shipping_address2" placeholder="Apartment or suite">
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                  <label for="country">Country</label>
                  <select class="custom-select d-block w-100" id="shipping_country" name="shipping_country">
                    <option value="">Choose...</option>
                    <option>United States</option>
                  </select>
               </div>
               <div class="col-md-4 mb-3">
                  <label for="state">State</label>
                  <select name="shipping_state" class="custom-select d-block w-100" id="shipping_state">
                    <option value="">Choose...</option>
                    <option>California</option>
                  </select>
               </div>
               <div class="col-md-3 mb-3">
                  <label for="shipping_zip">Zip</label>
                  <input type="text" class="form-control" id="shipping_zip" name="shipping_zip">
              </div>
            </div>
          </div>
            <hr class="mb-4">

           <input class="btn btn-primary btn-lg btn-block" type="submit" name="checkout" value="Paypal Checkout">
        </form>

      
    </div>
  </div>

@endsection 


@section('scripts')
    
<script type="text/javascript">
    $(function(){
          $('#same-address').on('change',function(){
                 $("#shipping_address").slideToggle(!this.checked);
          });
    });
   
</script>

@endsection 