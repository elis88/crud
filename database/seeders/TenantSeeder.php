<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Project;
use App\Models\Tenant;
use Symfony\Component\Uid\Ulid;

class TenantSeeder extends Seeder
{
    public function run()
    {
        $tenants = [
            [
                'name' => 'Tenant 1',
                'prefix' => 'tenant1',
                'database' => 'testing20',
            ],
            [
                'name' => 'Tenant 2',
                'prefix' => 'tenant2',
                'database' => 'testing21',
            ],
        ];

        foreach ($tenants as $tenantData) {

            $tenant = Tenant::create($tenantData);
            $tenant->makeCurrent();

            $admin = User::create([
                'id' => Ulid::generate(),
                'name' => 'Admin User',
                'email' => 'admin@'.$tenantData['prefix'].'.com',
                'password' => bcrypt('password'),
            ]);
            $admin->assignRole('admin');

            Project::create([
                'id' => Ulid::generate(),
                'name' => 'Project for ' . $tenantData['name'],
                'description' => 'Description of project for ' . $tenantData['name'],
                'creator_id' => $admin->id,
            ]);

            Tenant::forgetCurrent();
        }
    }
}
