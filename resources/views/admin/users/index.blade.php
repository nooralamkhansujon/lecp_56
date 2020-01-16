@extends('admin.app')
@section('header','User List')


@section('breadcrumbs')
   <li class="breadcrumb-item">
      <a href="{{route('admin.dashboard')}}">Dashboard</a>
   </li>
   <li class="breadcrumb-item active" 
   aria-current="page">Users</li>
@endsection 

@section('button_link')
   <a href="{{route('admin.profile.create')}}" 
   class="btn btn-secondary">Add User</a>
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
               <th width="10%">Name</th>
               <th width="10%">Email</th>
               <th width="5%">Slug</th>
               <th width="5%">Role</th>
               <th width="20%">Address</th>
               <th width="5%">Thumbnail</th>
               <th width="5%">Date Created</th>
               <th width="20%">Actions</th>
            </thead>
            <tbody>
            @if(isset($users) && $users->count() > 0)
               @foreach($users as $user)
                  <tr>
                     <td>{{ @$user->id }}</td>
                     <td>{{ @$user->profile->name }}</td>
                     <td>{!!@$user->email !!}</td>
                     <td>{{ @$user->profile->slug }}</td>
                     <td>{{ $user->role->name }}</td>
                     <td>{{ @$user->profile->address}},    
                     {{@$user->getcountry()}},{{@$user->getState()}},{{@$user->getCity() }}</td>
                     <td>
                       <img src="{{(isset($user->profile))?asset('images/profile/'.$user->profile->thumbnail):asset('images/default.jpg')}}" 
                       alt="{{@$user->profile->name}}" class="img-responsive" height="50" width="50">
                     </td>

                     @if($user->trashed())
                       <td>{{ @$user->deleted_at }}</td>
                       <td>
                          <a class="btn btn-info btn-sm" 
                          href="{{route('admin.profile.recover',$user->id)}}">Restore</a> 
                           ||
                          <a class="btn btn-danger btn-sm" 
                           href="javascript;;" 
                           onclick="confirmDelete('{{$user->id}}')">
                              Delete
                          </a>
                          <form id="delete-user-{{$user->id}}" 
                              action="{{route('admin.profile.destroy',$user->profile)}}"  
                              method="POST" style="display: none;">
                              @method('DELETE')
                              @csrf
                          </form>
                       </td>
                     @else
                        <td>{{ $user->created_at }}</td>
                        <td>
                           <a class="btn btn-info btn-sm" 
                           href="{{route('admin.profile.edit',$user->profile)}}">Edit</a> 
                              ||
                           <a class="btn btn-warning btn-sm" 
                           href="{{route('admin.profile.remove',$user->profile)}}">Trash</a>
                              ||
                           <a class="btn btn-danger btn-sm" 
                           href="javascript;;" 
                           onclick="confirmDelete('{{$user->id}}')">
                              Delete
                           </a>
                           <form id="delete-user-{{$user->id}}" 
                                 action="{{route('admin.profile.destroy',$user->profile)}}"  method="POST" 
                                 style="display: none;">
                                 @method('DELETE')
                                 @csrf
                           </form>
                        
                        </td>

                     @endif 
                       

                   
                  </tr> 
                  @endforeach 
            @else
                  <tr>
                     <td colspan="5">No Users Found..</td>
                  </tr>    
            @endif 
            </tbody>
      </table>
      <div class="row">
         <div class="col-md-12">
            {{$users->links()}}
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
         document.getElementById('delete-user-'+id).submit();
      }
   }
  </script>  

@endsection 