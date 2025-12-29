<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsDepartment extends Model
{
    use SoftDeletes;

    protected $table = 'ss_departments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'ss_organizations_id',
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function organization()
    {
        return $this->belongsTo(
            SsOrganization::class,
            'ss_organizations_id'
        );
    }

    public function users()
    {
        return $this->hasMany(
            SsUser::class,
            'ss_department_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes (optional)
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
