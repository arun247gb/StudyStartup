<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsStudyMilestoneCategoryTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ss_study_milestone_category_tasks';

    protected $fillable = [
        'ss_study_id',
        'ss_organisation_id',
        'updated_by',
        'assigned_to',
        'study_setup_type',
        'completion_type',
        'ss_study_milestone_category_id',
        'ss_milestone_category_tasks_id',
        'name',
        'description',
        'enum_status',
        'required',
        'planned_start_date',
        'planned_due_date',
        'actual_start_date',
        'actual_completion_date',
        'order',
    ];

    protected $casts = [
        'required'              => 'boolean',
        'order'                 => 'integer',
        'enum_status'           => 'integer',
        'planned_start_date'    => 'date',
        'planned_due_date'      => 'date',
        'actual_start_date'     => 'date',
        'actual_completion_date'=> 'date',
    ];

    public function category()
    {
        return $this->belongsTo(
            SsStudyMilestoneCategory::class,
            'ss_study_milestone_category_id'
        );
    }

    public function masterTask()
    {
        return $this->belongsTo(
            SsMilestoneCategoryTask::class,
            'ss_milestone_category_tasks_id'
        );
    }

    public function updatedBy()
    {
        return $this->belongsTo(SsUser::class, 'updated_by');
    }
}
