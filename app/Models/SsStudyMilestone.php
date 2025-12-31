<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsStudyMilestone extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ss_study_milestones';

    protected $fillable = [
        'ss_organisation_id',
        'ss_site_id',
        'ss_study_id',
        'ss_milestone_owner_id',
        'ss_milestone_id',
        'name',
        'enum_status',
        'order',
        'start_date',
        'planned_due_date',
        'actual_completion_date',
        'percent_complete',
    ];

    protected $casts = [
        'percent_complete' => 'decimal:2',
        'order'            => 'integer',
        'enum_status'      => 'integer',
        'start_date'       => 'date',
        'planned_due_date' => 'date',
        'actual_completion_date' => 'date',
    ];

    public function milestone()
    {
        return $this->belongsTo(SsMilestone::class, 'ss_milestone_id');
    }

    public function study()
    {
        return $this->belongsTo(SsStudy::class, 'ss_study_id');
    }

    public function categories()
    {
        return $this->hasMany(
            SsStudyMilestoneCategory::class,
            'ss_study_milestones_id'
        );
    }
}
