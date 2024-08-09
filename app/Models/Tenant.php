<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Artisan;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Spatie\Multitenancy\Models\Tenant as BaseTenant;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Uid\Ulid;


class Tenant extends BaseTenant
{
    use HasFactory, UsesLandlordConnection;

    protected $fillable = [
      'id',
      'name',
      'prefix',
      'database'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?? Ulid::generate();
        });
    }


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
