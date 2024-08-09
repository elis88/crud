<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Symfony\Component\Uid\Ulid;

class Project extends Model
{
    use HasFactory, UsesTenantConnection;

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?? Ulid::generate();
        });
    }

    protected $fillable = [
        'id',
        'name',
        'description',
        'creator_id'
    ];





    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
