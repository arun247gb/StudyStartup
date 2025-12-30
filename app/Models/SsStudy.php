<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsStudy extends Model
{
    use SoftDeletes;

    protected $table = 'ss_studies';

    protected $fillable = [
        'ss_organizations_id',
        'ss_site_id',
        'name',
        'protocol_number',
        'phase_id',
        'sponsor_id',
        'therapeutic_area_id',
        'description',
        'protocol_document_id',
        'planned_activation_date',
        'does_ctms_connected',
        'created_by',
    ];

    protected $casts = [
        'does_ctms_connected' => 'boolean',
        'planned_activation_date' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(SsOrganization::class, 'ss_organizations_id');
    }

    public function site()
    {
        return $this->belongsTo(SsSite::class, 'ss_site_id');
    }

    public function creator()
    {
        return $this->belongsTo(SsUser::class, 'created_by');
    }
}
