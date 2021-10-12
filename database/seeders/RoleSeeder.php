<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    private $permissions;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setUp();
    }

    private function setUp()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->initializeData();
        $this->createData();
    }

    private function initializeData()
    {
        $this->permissions = [
            // Job
            ['name' => 'get jobs'],
            ['name' => 'create jobs'],
            ['name' => 'update jobs'],
            ['name' => 'delete jobs'],
            //Company
            ['name' => 'get companies'],
            ['name' => 'create companies'],
            ['name' => 'update companies'],
            ['name' => 'delete companies'],
            // Resume
            ['name' => 'get resumes'],
            ['name' => 'create resumes'],
            ['name' => 'update resumes'],
            ['name' => 'delete resumes'],
            // User
            ['name' => 'get users'],
            ['name' => 'create users'],
            ['name' => 'update users'],
            ['name' => 'delete users'],
            // Role
            ['name' => 'get roles'],
            ['name' => 'create roles'],
            ['name' => 'update roles'],
            ['name' => 'delete roles'],
        ];
    }

    private function createData()
    {
        // create permissions
        foreach ($this->permissions as $value) {
            Permission::create($value);
        }

        // Role::create(['name' => 'super-admin'])
        //     ->givePermissionTo(Permission::all());

        Role::create(['name' => 'staff'])
            ->givePermissionTo(Permission::all());

        // create roles and assign created permissions
        Role::create(['name' => 'customer'])
            ->givePermissionTo([
                // Job
                'get jobs', 'create jobs', 'update jobs', 'delete jobs',
                //Company
                'get companies', 'update companies', 'delete companies',
                // User (Type Applicant)
                'get users', 'update users', 'delete users',
                // Resume (Review)
                'get resumes', 'update resumes', 'delete resumes',
            ]);

        Role::create(['name' => 'applicant'])
            ->givePermissionTo([
                // Job
                'get jobs',
                //Company
                'get companies',
                // Resume (Review)
                'get resumes', 'create resumes', 'update resumes', 'delete resumes',
            ]);
    }
}
