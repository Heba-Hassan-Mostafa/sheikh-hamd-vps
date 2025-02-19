<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Admin Seeder
        $user = User::create([

            'first_name' => 'Heba',
            'last_name' => 'Hassan',
            'email' => 'bebamohammed0@gmail.com',
            'password' => bcrypt('123123123'),
            'phone'   =>'01147538409',
            'image' =>'avatar.png',
            'status' =>'1',
            'email_verified_at' =>now(),
            'remember_token' =>Str::random(10),
        ]);

        $role = Role::create(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
