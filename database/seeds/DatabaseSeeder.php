<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use App\Profile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(\AdminUser::class);

        $role = Role::create([
            'name'        => "Customer",
            'description' => 'Customer Role'
        ]);
        $role = Role::create([
            'name'        => 'admin',
            'description' => 'Admin Role'
        ]);
        $user = User::create([
            'email'     => 'admin@admin.com',
            'password'  => Hash::make('testing321'),
            'role_id'   => $role->id
        ]);
        Profile::create([
             'user_id' => $user->id,
        ]);
        
    }

}
