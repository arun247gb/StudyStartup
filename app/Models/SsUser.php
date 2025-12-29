<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class SsUser extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'ss_users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'ss_organization_id',
        'ss_department_id',
        'name',
        'email',
        'password',
        'auth_source',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'auth_source' => 'local',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function organization()
    {
        return $this->belongsTo(SsOrganization::class, 'ss_organization_id');
    }

    public function department()
    {
        return $this->belongsTo(SsDepartment::class, 'ss_department_id');
    }
}
