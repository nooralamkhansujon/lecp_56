@extends('admin.app')


@section('header','Add/Edit Category');

@section('breadcrumbs')
   <li class="breadcrumb-item">
     <a href="{{route('admin.dashboard')}}">Dashboard</a>
   </li>
   <li class="breadcrumb-item" >
     <a href="{{route('admin.category.index')}}">Categories</a>
  </li>
  <li class="breadcrumb-item active" 
   aria-current="page">Add/Edit Category</li>
   
@endsection 

@section('content')  
 <form action="{{(isset($category))? route('admin.category.update',$category->id):route('admin.category.store')}}" method="POST" accept-charset="utf-8">
      @if(isset($category))
        @method('PUT')
      @endif 
      @csrf 
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

      <div class="form-group row">
          <div class="col-sm-12">
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
      
         <div class="col-sm-12">
          <label class="form-control-label">Title:</label>
             <input type="text" id="txturl" name="title" class="form-control" value="{{ @$category->title }}">
             <p class="small"> {{config('app.url')}}
                <span id="url">{{ @$category->slug }}</span>
             </p>
             <input type="hidden" name="slug" id="slug" 
             value="{{ @$category->slug }}">
         </div>
      </div>

      <div class="form-group row">
         <div class="col-sm-12">
            <label class="form-control-label">Description:</label>
            <textarea name="description" class="form-control" id="editor" rows="10" cols="80">
                {!! @$category->description !!}
            </textarea>
         </div>
      </div>

      <div class="form-group row">
          @php 
             if(isset($category))
             {
                if($category->childrens->count() > 0)
                    $ids = array_pluck($category->childrens,'id');
                else
                    $ids = null;
             }
          @endphp 
         <div class="col-sm-12">
           <label class="form-control-label">Select Category: </label>
           <select id="parent_id" name="parent_id[]" class="form-control" multiple="multiple">
                @if(isset($categories))
                    <option value="0">Top Level</option>
                    @foreach($categories as $cat)
                        <option value="{{$cat->id }}" 
                            {{( isset($ids) && in_array($cat->id,$ids))?'selected':'' }}> 
                            {{$cat->title}} 
                        </option>
                    @endforeach 
                @endif 
           </select>
         </div>
      </div>

      <div class="form-group row">
           <div class="col-sm-12">
            @if(isset($category))
                   <input type="submit" name="submit" 
                    class="btn btn-primary" value="Edit Category" /> 
            @else 
                   <input type="submit" name="submit" 
                    class="btn btn-primary" value="Add Category" /> 
            @endif 
           
           </div>
      </div>
  
  </form>
@endsection 

@section('scripts')
<script type="text/javascript">


    $(function(){
        ClassicEditor.create(document.querySelector('#editor'),{
           toolbar : ['Heading','Link','bold','italic','bulletedList','numberedList','blockQuote','undo','redo'],
        }).then(editor => {
            console.log(editor);
        }).catch(error=>{
            console.log(error);
        });

        $("#txturl").on('keyup',function(){
            var url   = slugify($(this).val());
            $('#url').html(url);
            $('#slug').val(url);
            console.log(url);
        });

       
    });
</script>
@endsection 