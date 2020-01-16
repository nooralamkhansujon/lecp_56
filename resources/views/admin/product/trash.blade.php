@extends('admin.app')
@section('header','Product')

@section('breadcrumbs')
   <li class="breadcrumb-item">
      <a href="{{route('admin.dashboard')}}">Dashboard</a>
   </li>
   <li class="breadcrumb-item active" 
   aria-current="page">Products</li>
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
            <ul>
               <li>{{ session()->get('message') }}</li>
            </ul>
         </div>
      @endif
   </div>
</div>

<div class="table-responsive">
      <table class="table table-striped table-sm">
            <thead>
               <th width="5%">No</th>
               <th width="10%">Title</th>
               <th width="20%">Description</th>
               <th width="5%">Slug</th>
               <th width="10%">Categories</th>
               <th width="10%">Price</th>
               <th width="10%">Thumbnail</th>
               <th width="10%">Date Created</th>
               <th width="20%">Actions</th>
            </thead>
            <tbody>
            @if($products)
               @foreach($products as $product)
                  <tr>
                     <td> {{ $product->id }}</td>
                     <td> {{ $product->title }}</td>
                     <td>{!! $product->description !!}</td>
                     <td>{{  $product->slug }}</td>
                     <td>
                        @if(count($product->categories))
                           @foreach($product->categories as $cat)
                              {{$cat->title}},
                           @endforeach 
                        @else 
                            <strong>Parent Category</strong>
                        @endif 
                     </td>
                     <td>{{ $product->price }}</td>
                     <td>
                         <img width="50" height="50" 
                           src="{{asset('images/'.$product->thumbnail)}}"  alt="">
                     </td>
                     <td>{{$product->created_at}}</td>
                     <td>
                        <a class="btn btn-info btn-sm" 
                        href="{{route('admin.product.recover',$product->id)}}">Recover</a> 
                           ||
                        <a class="btn btn-danger btn-sm" 
                        href="javascript;;" 
                        onclick="confirmDelete('{{$product->id}}')">
                           Delete
                        </a>
                    
                        <form id="delete-product-{{$product->id}}" 
                              action="{{route('admin.product.destroy',$product)}}"  method="POST" style="display: none;">
                              @method('DELETE')
                              @csrf
                        </form>
                        
                     </td>
                  </tr> 
                  @endforeach 
            @else
                  <tr>
                     <td colspan="5">No Category Found..</td>
                  </tr>    
            @endif 
            </tbody>
      </table>
      <div class="row">
         <div class="col-md-12">
            {{$products->links()}}
         </div>
      </div>
</div>


@endsection 

@section('scripts')
<script type="text/javascript">

   function confirmDelete(id)
   {
      event.preventDefault();
      let choice = confirm('Are you sure, you want to Delete this record?');
      
      if(choice)
      {
         document.getElementById('delete-product-'+id).submit();
      }
   }
  </script>  


@endsection 