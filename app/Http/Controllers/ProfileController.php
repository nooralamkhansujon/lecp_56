<?php

namespace App\Http\Controllers;

use App\Profile;
use App\User;
use App\Role;
use App\Country;
use App\State;
use App\City;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserProfile;
use Hash;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $users = User::with('role','profile')->paginate(3);
       return view('admin.users.index',compact('users')); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles     = Role::all();
        $countries = Country::all();
        return view('admin.users.create',compact('roles','countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserProfile $request)
    {
        
        // dd($request->all());
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status'   => $request->status,
        ]);

        if(isset($request->role_id))
        {
             $user->role_id = $request->role_id;
        }

        if($user)
        {
           
            $profile = Profile::create([
                'user_id'      => $user->id,
                'name'         => $request->name,
                'address'      => (isset($request->address))?$request->address:null,
                'phone'        => (isset($request->phone))?$request->phone:null,
                'slug'         => $request->slug,
                'country_id'   => (isset($request->country_id))?$request->country_id:null,
                'state_id'     => (isset($request->state_id))?$request->state_id:null,
                'city_id'      => (isset($request->city_id))?$request->city_id:null,
            ]);


            if(isset($request->thumbnail))
            {
                $name             = $this->makethumbnail($request);
                move_uploaded_file($request->thumbnail,public_path('images/profile/'.$name));
                $profile->thumbnail = $name;
                $profile->save();
            }
            
            if($user && $profile)
            {
                return redirect()->route('admin.profile.index')
                ->with('message','User Created Successfully');
            }
            else{
                return back()->with('message','Error Inserting new User');
            }
          
        }
    }

    private function makethumbnail(Request $request)
    {
        $thumbnail = $request->thumbnail;
        $extension = ".".$thumbnail->getClientOriginalExtension();
        $name      = basename($thumbnail->getClientOriginalName(),$extension).time();
        $name      = $name.$extension; 
        return $name;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function getCities($id)
    {
        if(request()->ajax())
        {
            $state    = State::find($id);
            $cities   = City::where('state_id','=',$state->id)->get();
            $data  = '<option value="0">
                        Select City
                      </option>';
            foreach($cities as $city)
            {
                $data  .='<option value="'.$city->id.'">
                           '.$city->name.'</option>';
            }
           
           echo $data;
        }
        return 0;
    }

    public function getStates($id)
    {
        if(request()->ajax())
        {
            $country  = Country::find($id);
            $states   = State::where('country_id','=',$country->id)->get();
            $data  = '<option value="0">
            Select State </option>';
            foreach($states as $state)
            {
                $data  .='<option value="'.$state->id.'">
                           '.$state->name.'</option>';
            }
           
           echo $data;
        }
        else{
            return 0;
        }
       
    }
}
