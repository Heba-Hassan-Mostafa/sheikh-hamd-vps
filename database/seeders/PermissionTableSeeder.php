<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permissions
        $permissions = [
           'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete'
        ];
        // $routes = [
        //     'roles.index',
        //     'roles.create,roles.store',
        //     'roles.edit,roles.update',
        //     'roles.destroy',
        //     'users.index',
        //     'users.create,users.store',
        //     'users.edit.users.update',
        //     'users.destroy'
        // ];

        foreach ($permissions as $permission) {

            Permission::create(['name'=>$permission]);

    }
    }
}
