<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsStudyStaff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ss_organizations_id',
        'ss_study_id',
        'ss_user_id',
        'name',
        'enum_staff_type_id',
        'description',
        'created_by',
    ];

    public function study()
    {
        return $this->belongsTo(SsStudy::class, 'ss_study_id');
    }

    public function user()
    {
        return $this->belongsTo(SsUser::class, 'ss_user_id');
    }

    public function creator()
    {
        return $this->belongsTo(SsUser::class, 'created_by');
    }

    public function organization()
    {
        return $this->belongsTo(SsOrganization::class, 'ss_organizations_id');
    }
}
