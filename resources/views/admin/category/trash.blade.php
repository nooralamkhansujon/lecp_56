@extends('admin.app')
@section('header','Category List')


@section('breadcrumbs')
   <li class="breadcrumb-item">
      <a href="{{route('admin.dashboard')}}">Dashboard</a>
   </li>
   <li class="breadcrumb-item active" 
   aria-current="page">Categories</li>
@endsection 

@section('button_link')
   <a href="{{route('admin.category.create')}}" 
   class="btn btn-secondary">Add Category</a>
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
               <th width="25%">Description</th>
               <th width="10%">Slug</th>
               <th width="20%">Categories</th>
               <th width="10%">Date Created</th>
               <th width="20%">Actions</th>
            </thead>
            <tbody>
            @if($categories)
               @foreach($categories as $category)
                  <tr>
                     <td>{{ $category->id }}</td>
                     <td>{{ $category->title }}</td>
                     <td>{!! $category->description !!}</td>
                     <td>{{  $category->slug }}</td>
                     <td>
                        @if(count($category->childrens))
                           @foreach($category->childrens as $children)
                              {{$children->title}},
                           @endforeach 
                        @else 
                           <strong>Parent Category</strong>
                        @endif 
                     </td>
                     <td>{{$category->created_at}}</td>
                     <td>
                        <a class="btn btn-info btn-sm" 
                        href="{{route('admin.category.recover',$category->id)}}">recover</a> ||
                        <a class="btn btn-danger btn-sm" 
                        href="javascript;;" 
                        onclick="confirmDelete('{{$category->id}}')">
                           Delete
                        </a>
                        <form id="delete-category-{{$category->id}}" 
                              action="{{route('admin.category.destroy',$category->id)}}"  method="POST" style="display: none;">
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
            {{$categories->links()}}
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
         // console.log(document.getElementById('delete-category-'+id));
         document.getElementById('delete-category-'+id).submit();
      }
   }
  </script>  

@endsection 