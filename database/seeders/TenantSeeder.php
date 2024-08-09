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
                'id' => Ulid::generate(),
                'name' => 'Tenant 1',
                'domain' => 'tenant1.example.com',
                'database' => 'testing20',
            ],
            [
                'id' => Ulid::generate(),
                'name' => 'Tenant 2',
                'domain' => 'tenant2.example.com',
                'database' => 'testing21',
            ],
        ];

        foreach ($tenants as $tenantData) {

            $tenant = Tenant::create($tenantData);
            $tenant->makeCurrent();

            $admin = User::create([
                'id' => Ulid::generate(),
                'name' => 'Admin User',
                'email' => 'admin@' . $tenantData['domain'],
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
