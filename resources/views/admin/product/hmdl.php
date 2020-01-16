<div class="form-group row">
   <div class="col-sm-12">
        @if(session()->has('message'))
            <div class="alert alert-success">
                <ul>
                <li>{{ session()->get('message') }}</li>
                </ul>
            </div>
        @endif
   </div>
</div>

 <form action="{{route('admin.product.store')}}" method="POST" 
 accept-charset="utf-8" enctype="multipart/form-data">
   @csrf
   <div class="row">
      <!-- start of col-lg-9  -->
      <div class="col-lg-9">
          <div class="form-group row">
              <div class="col-lg-12">
                  <label class="form-control-label">Title: </label>
                  <input type="text" id="txturl" name="title" 
                    class="form-control" value="{{@$product->title}}" />
                    <p class="small">{{config('app.url')}}
                     <span id="url">{{@$product->slug}}</span>
                     <input type="hidden" name="slug" id="slug">
                    </p>
              </div>
          </div>
          <div class="form-group row">
              <div class="col-lg-12">
                  <label class="form-control-label">Description: </label>
                  <textarea name="description" id="editor" class="form-control" cols="30" rows="10">
                     {!! @$product->description !!}
                  </textarea>
              </div>
          </div>
          
          <!-- start of form group  -->
          <div class="form-group row">
              <div class="col-6">
                  <label class="form-control-label">Price: </label>
                  <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">$</span>
                        </div>
                        <input type="text" class="form-control" placeholder="0.00" aria-label="Username" 
                           value="{{@$product->price}}">
                  </div>
              </div>

              <div class="col-6">
                 <label class="form-control-label">Discount: </label>
                 <div class="input-group mb-3">
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">$</span>
                     </div>
                     <input type="text" class="form-control" name="discount_price" placeholder="0.00" 
                     aria-label="discount_price" aria-describedby="discount" value="{{@$product->discount_price}}" />
                 </div>
              </div>

          </div>

          <!-- end of form group  -->
          <div class="form-group row">
                <!-- card start  -->
               <div class="card col-sm-12 p-0 mb-2">
                   <!-- start of card header  -->
                   <div class="card-header align-items-center">
                       <h5 class="card-title float-left">Extra Options</h5>
                       <div class="float-right">
                          <button type="button" id="btn-add" class="btn btn-primary btn-sm">+</button>
                          <button type="button" id="btn-remove" class="btn btn-danger btn-sm">-</button>
                       </div>
                   </div>
                   <!-- end of card header  -->
                   <div class="card-body" id="extras">
                        <div class="row align-items-center options">
                           <div class="col-sm-4">
                              <label class="form-control-label">
                                Options <span class="count">1</span>
                              </label>
                              <input type="text" name="extra['options'][]" class="form-control" placeholder="size" />
                           </div>
                           <div class="col-md-8">
                              <label class="form-control-label">Values</label>
                              <input type="text" name="extra['values'][]" class="form-control" placeholder="option1 | option2 | option3">
                              <label class="form-control-label">Additional Prices</label>
                              <input type="text" name="extra['prices'][]" class="form-control" placeholder="price1 | price2 | price3" />
                           </div>
                        </div>

                   </div>
               </div>
               <!-- end of card  -->
          </div>

      </div>
      <!-- end of col-lg-9  -->
      <div class="col-lg-3">
         <ul class="list-group row">
            <li class="list-group-item active"><h5>Status</h5></li>
            <li class="list-group-item">
               <div class="form-group row">
                    <select class="form-control" id="status">
                        <option value="1">Pending</option>
                        <option value="2">Publish</option>
                    </select>
               </div>
               <div class="form-group row">
                  <div class="col-lg-12">
                      <input type="submit" name="submit" class="btn btn-primary btn-block" value="Add Product">
                  </div>
               </div>
            </li>
            <li class="list-group-item active">
               <h5>Featured Image</h5>
            </li>

            <li class="list-group-item">
              <div class="input-group mb-3">
                  <div class="custom-file">
                     <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail">
                     <label class="custom-file-label" for="thumbnail">Choose File</label>
                  </div>
              </div>
              <div class="img-thumbnail text-center">
                 <img src="@if(isset($product)) {{asset('images/'.$product->thumbnail)}} @else {{asset('images/default.jpg')}}" alt="" />
              </div>
            </li>

            <li class="list-group-item">
               <div class="col-12">
                    <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <span class="input-group-text" id="featured">
                             <input type="checkbox" name="discount" value="0">
                           </span>
                         </div>
                         <p type="text" class="form-control"  name="featured" placeholder="0.00"  
                         aria-label="featured" aria-describedby="featured">Featured Product</p>
                    </div>
               </div>
            </li>

            <li class="list-group-item active"><h5>Select Categories</h5></li>
             
            <li class="list-group-item">
                <select name="categories" id="">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                        <option value="4">Four</option>
                        <option value="5">Five</option>
                </select> 
            </li>
         </ul>
     </div>

</div>
 </form>