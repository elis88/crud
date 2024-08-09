<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Artisan;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;
use Illuminate\Support\Facades\DB;


class Tenant extends BaseTenant
{
    use HasFactory, UsesLandlordConnection;

    protected $fillable = [
      'id',
      'name',
      'domain',
      'database'
    ];

    public static function booted()
    {
        static::creating(function (Tenant $tenant) {

            $query = "CREATE DATABASE IF NOT EXISTS $tenant->database;";
            DB::statement($query);

        });

        static::created(function(Tenant $tenant){
            Artisan::call('tenants:artisan "migrate --database=tenant"');
        });
    }


}
