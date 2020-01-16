@extends('admin.app')
@section('header','Add/Edit Product List')


@section('breadcrumbs')
   <li class="breadcrumb-item">
      <a href="{{route('admin.dashboard')}}">Dashboard</a>
   </li>
   <li class="breadcrumb-item">
      <a href="{{route('admin.product.index')}}">Products</a>
   </li>
   <li class="breadcrumb-item active" 
   aria-current="page">Add/Edit Product</li>
@endsection 

@section('button_link')
   <a href="{{route('admin.product.create')}}" 
   class="btn btn-secondary">Add Product</a>
@endsection 

@section('content')
    
<div class="form-group row">
   <div class="col-sm-12">
        @if(session()->has('message'))
            <div class="alert alert-success">
                   <li>{{ session()->get('message') }}</li>
            </div>
        @endif
   </div>
</div>

<div class="form-group row">
  <div class="col-md-12">
      @if ($errors->any())
            <div class="alert alert-danger">
               <ul>
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
               </ul>
            </div>
      @endif
  </div>
</div>



 <form action="{{(isset($product))? route('admin.product.update',$product):route('admin.product.store')}}" method="POST" 
 accept-charset="utf-8" enctype="multipart/form-data">
   @csrf
   @if(isset($product))
      @method('PUT')
   @endif 
   <div class="row">
      <!-- start of col-lg-9  -->
      <div class="col-lg-8">
          <div class="form-group row">
              <div class="col-lg-12">
                  <label class="form-control-label">Title: </label>
                  <input type="text" id="txturl" name="title" 
                    class="form-control" value="{{@$product->title}}" />
                    <p class="small">{{config('app.url')}}
                     <span id="url">{{@$product->slug}}</span>
                     <input type="hidden" name="slug"  id="slug">
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
                        <input type="text" name="price" class="form-control" placeholder="0.00" aria-label="Username" 
                           value="{{@$product->price}}">
                  </div>
              </div>

              <div class="col-6">
                 <label class="form-control-label">Discount: </label>
                 <div class="input-group mb-3">
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">$</span>
                     </div>
                     <input type="text" class="form-control" name="discount_price" id="discount_price" placeholder="0.00" 
                     aria-label="discount_price" aria-describedby="discount" 
                     value="{{@$product->discount_price}}" />
                     <input type="hidden" name="discount" id="discount" />
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
                   </div>
               </div>
               <!-- end of card  -->
          </div>

      </div>
      <!-- end of col-lg-9  -->
      <div class="col-lg-4">
         <ul class="list-group row">
            <li class="list-group-item active"><h5>Status</h5></li>
            <li class="list-group-item">
               <div class="form-group row">
                    <select class="form-control" name="status"  id="status">
                        
                        <option value="0" 
                        {{(@$product->status == 0 )? 'selected':''}}>Pending</option>
                        <option value="1"  
                        {{(@$product->status == 1 )? 'selected':''}}>Publish</option>7
                    </select>
               </div>
               <div class="form-group row">
                  <div class="col-lg-12">
                     @if(isset($product))
                         <input type="submit" name="submit" class="btn btn-primary btn-block" value="Edit Product" />
                     @else 
                          <input type="submit" name="submit" class="btn btn-primary btn-block" value="Add Product" />
                     @endif 
                    
                  </div>
               </div>
            </li>
            <li class="list-group-item active">
               <h5>Featured Image</h5>
            </li>

            <li class="list-group-item">
              <div class="input-group mb-3">
                  <div class="custom-file">
                     <input type="file"  class="custom-file-input" name="thumbnail" id="thumbnail">
                     <label class="custom-file-label" for="thumbnail">Choose File</label>
                  </div>
              </div>
              <div class="img-thumbnail text-center">
                 <img style="width:100%;" id="imgthumbnail" height="200px" 
                 src="{{ (isset($product)) ? asset('images/'.$product->thumbnail): asset('images/default.jpg') }}" alt="" />
              </div>
            </li>

            <li class="list-group-item">
               <div class="col-12">
                    <div class="input-group mb-3">
                         <div class="input-group-prepend">
                           <span class="input-group-text" >
                             <input id="featured" type="checkbox" {{(isset($product) && $product->featured == '1' )? "checked" : ''}}  name="featured" value="{{(isset($product))? $product->featured : 0 }}" />
                           </span>
                         </div>
                         <p type="text" class="form-control" placeholder="0.00"  
                         aria-label="featured" aria-describedby="featured">
                         Featured Product
                         </p>
                    </div>
               </div>
            </li>
             @php 
                 if(isset($product->categories))
                 {
                    if($product->categories->count() > 0 )
                        $ids = array_pluck($product->categories,'id');
                    else
                       $ids  = null;
                 }
             @endphp 
            <li class="list-group-item active"><h5>Select Categories</h5></li>
            <li class="list-group-item">
                <select name="category_id[]"  class="form-control" multiple>
                     <option value="" {{(isset($product->categories))?:'selected'}}>
                       Select multiple Categories
                     </option>
                     @if($categories->count() > 0)
                          @foreach($categories as  $category)
                          <option value="{{$category->id }}" 
                            {{( isset($ids) && in_array($category->id,$ids))?'selected':'' }}> 
                            {{$category->title}} 
                        </option>
                           @endforeach 
                     @endif 
                </select> 
            </li>
         </ul>
     </div>

</div>
 </form>
  

@endsection 




@section('scripts')

<script type="text/javascript"> 

   function confirmDelete(id)
   {
      event.preventDefault();
      let choice = confirm('Are you sure, you want to Delete this record?');
      if(choice)
      {
         document.getElementById('delete-category-'+id).submit();
      }
   }

   $(function(){
        ClassicEditor.create(document.querySelector('#editor'),{
           toolbar : ['Heading','Link','bold','italic','bulletedList','numberedList','blockQuote','undo','redo'],
        }).then(editor => {
            console.log(editor);
        }).catch(error=>{
            console.log(error);
        });
        
      
         @if(!isset($product))
               $("#txturl").on('keyup',function(){
               const url = slugify($(this).val());
               $('#url').html(url);
               $('#slug').val(url);
               // console.log(url);
               });
         @endif
      
       
    });

    $("#thumbnail").on('change',function(){

         let file = $(this).get(0).files;
         let reader = new FileReader();
         // console.log(file);
         reader.readAsDataURL(file[0]);
         reader.addEventListener('load',function(e){
              let image = e.target.result;
              $("#imgthumbnail").attr('src',image);
         });
    });

    $("#btn-add").on('click',function(e){
          let count = $(".options").length+1;
          
          let html = `<br><div class="row align-items-center options">
                           <div class="col-sm-4">
                              <label class="form-control-label">
                                Options 
                                <span class="count">${count}</span>
                              </label>
                              <input type="text" 
                              name="extra[options][]" class="form-control" placeholder="size" 
                              />
                           </div>
                           <div class="col-md-8">
                              <label class="form-control-label">Values</label>
                              <input type="text" name="extra[values][]" class="form-control" placeholder="option1 | option2 | option3">
                              <label class="form-control-label">Additional Prices</label>
                              <input type="text" name="extra[prices][]" class="form-control" placeholder="price1 | price2 | price3" />
                           </div>
                        </div>`;
          $("#extras").append(html);
    });

    $('#btn-remove').on('click',function(e){
         if($('.options').length > 1){
             $(".options:last").remove();
         }
    });

    $("#discount_price").on('keyup',function(e){
            
         value = this.value;
         if(value != ' ' && value > 0)
         {
            $('#discount').val(1);
         }
    });

    $("#featured").on('change',function(){
           
           if($(this).is(':checked'))
               $(this).val(1);
           else 
               $(this).val(0);


            console.log(this.value);   
    });  

  </script>  

@endsection 