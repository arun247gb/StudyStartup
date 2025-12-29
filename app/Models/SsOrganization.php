<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SsOrganization extends Model
{
    protected $table = 'ss_organizations';

    protected $primaryKey = 'id';

    public $timestamps = false; 

    protected $fillable = [
        'name',
        'type',
        'account_type',
        'external_ctms_id',
    ];

    protected $casts = [
        'id' => 'integer',
    ];


    public function users()
    {
        return $this->hasMany(SsUser::class, 'ss_organization_id');
    }

    public function scopeSponsors($query)
    {
        return $query->where('type', 'sponsor');
    }

    public function scopeCros($query)
    {
        return $query->where('type', 'cro');
    }

    public function scopeCtmsConnected($query)
    {
        return $query->where('account_type', 'ctms_connected');
    }
}
