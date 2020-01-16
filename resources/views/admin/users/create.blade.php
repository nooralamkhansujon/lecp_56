@extends('admin.app')
@section('header','Add/Edit User List')


@section('breadcrumbs')
   <li class="breadcrumb-item">
      <a href="{{route('admin.dashboard')}}">Dashboard</a>
   </li>
   <li class="breadcrumb-item">
      <a href="{{route('admin.profile.index')}}">Users </a>
   </li>
   <li class="breadcrumb-item active" 
   aria-current="page">Add/Edit User</li>
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



 <form action="{{(isset($user))? route('admin.profile.update',$user):route('admin.profile.store')}}" method="POST" 
 accept-charset="utf-8" enctype="multipart/form-data">
   @csrf
   @if(isset($user))
      @method('PUT')
   @endif 
   <div class="row">
      <!-- start of col-lg-9  -->
      <div class="col-lg-8">
          <div class="form-group row">
              <div class="col-lg-12">
                  <label class="form-control-label">Name: </label>
                  <input type="text" id="name" name="name" 
                    class="form-control" placeholder="Enter Name"
                      value="{{@$user->profile->name}}" />
                    <p class="small">{{config('app.url')}}
                      <span id="url">{{@$user->profile->slug}}</span>
                      <input type="hidden" name="slug"  id="slug">
                    </p>
              </div>

              <div class="col-lg-12">
                  <label class="form-control-label">Email: </label>
                  <input type="text" id="email" name="email"    placeholder="Enter Email" class="form-control" 
                      value="{{@$user->email}}" />
              </div>
          </div>

          <div class="form-group row">
              <div class="col-lg-12">
                  <label class="form-control-label">Password: </label>
                  <input type="password" id="password" name="password" class="form-control" />
              </div>

              <div class="col-lg-12">
                  <label class="form-control-label">
                    Re-Type Password: </label>
                  <input type="password" id="password_confirm"  name="password_confirm" class="form-control"  />
              </div>
          </div>

          <div class="form-group row">
              <div class="col-lg-6">
                  <label class="form-control-label">Status: </label>
                  <select name="status" id="status" class="form-control">
                         <option value="0" {{ (@$user->status == '0')? 'selected' : '' }}>Blocked</option>
                         <option value="1" {{ (@$user->status == '1')? 'selected' : '' }}>Active</option>
                  </select>
              </div>
              <div class="col-lg-6">
                  <label class="form-control-label">
                    Select Role
                  </label>
                  <select class="form-control" name="role_id" id="role">
                    <option value="0">Select Role</option>
                    @foreach($roles as $role)
                      <option value="{{$role->id}}">
                        {{$role->name}}
                      </option>
                    @endforeach 
                  </select>
              </div>
          </div>

           <div class="row">
             <div class="col-md-12"><h2>Address</h2></div>
           </div>
           <div class="form-group row">
             <div class="col-md-12">
                 <label class="form-control-label">Address: </label>
                  <input type="text" name="address" class="form-control">
              </div>
           </div>

           <div class="row">
             <div class="col-md-3">
                  <label class="form-control-label">Country: </label>
                  <select class="form-control" name="country_id" 
                  id="countries">
                       <option value="0">
                           Select Country
                        </option>
                      @foreach($countries as $country)
                          <option value="{{$country->id}}">
                            {{$country->name}}
                          </option>
                      @endforeach 
                   </select>
              </div>
              <div class="col-md-3">
                  <label class="form-control-label">State: </label>
                  <select class="form-control" name="state_id" id="states">

                  </select>
              </div>
              <div class="col-md-3">
                  <label class="form-control-label">City: </label>
                  <select class="form-control" name="city_id" id="cities">

                  </select>
              </div>
              <div class="col-md-3">
                 <label class="form-control-label">Phone: </label>
                  <input type="text" name="phone" class="form-control" 
                  placeholder="Phone" value="{{@$user->profile->phone}}">
              </div>
           </div>
          

        </div>
      <!-- end of col-lg-8  -->
      <div class="col-lg-4">
         <ul class="list-group row">
            <li class="list-group-item active"><h5>Profile Image</h5></li>
            <li class="list-group-item">
              <div class="input-group mb-3">
                  <div class="custom-file">
                     <input type="file"  class="custom-file-input" name="thumbnail" id="thumbnail">
                     <label class="custom-file-label" for="thumbnail">Choose File</label>
                  </div>
              </div>
              <div class="img-thumbnail text-center">
                 <img style="width:100%;" id="imgthumbnail" height="200px" src="{{ (isset($user)) ? asset('images/'.$user->thumbnail): asset('images/default.jpg') }}" alt="" />
              </div>
            </li>
             <li>
                <button type="submit" class="btn btn-info btn-block">Add User</button>
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
               $("#name").on('keyup',function(){
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
                              name="extra[options][]" class="form-control" 
                              placeholder="size" />
                           </div>
                           <div class="col-md-8">
                              <label class="form-control-label">Values</label>
                              <input type="text" name="extra[values][]" class="form-control" placeholder="option1 | option2 | option3">
                              <label class="form-control-label">Additional Prices</label>
                              <input type="text" 
                              name="extra[prices][]" class="form-control" placeholder="price1 | price2 | price3" />
                           </div>
                        </div>`;
          $("#extras").append(html);
    });

    $('#btn-remove').on('click',function(e){
         if($('.options').length > 1){
             $(".options:last").remove();
         }
    });

   $('#countries').on('change',function(){
        let id = this.value;

        $.ajax({
            type:"GET",
            url:"{{url('admin/profile/states')}}/"+id,
            success:function(data)
            {
               // console.log(data);
               $('#states').html(data);
           }
         });
   });
  
   $('#states').on('change',function(){
        let id = this.value;

        $.ajax({
            type: "GET",
            url : "{{url('admin/profile/cities')}}/"+id,
            success:function(data)
            {
               $('#cities').html(data);
           }
         });
   });
  

  </script>  

@endsection 