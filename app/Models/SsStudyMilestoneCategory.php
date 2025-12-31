<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsStudyMilestoneCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ss_study_milestone_categories';

    protected $fillable = [
        'ss_study_id',
        'ss_organisation_id',
        'ss_study_milestones_id',
        'ss_milestone_category_id',
        'study_category_name',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'order'     => 'integer',
        'is_active' => 'boolean',
    ];

    public function studyMilestone()
    {
        return $this->belongsTo(
            SsStudyMilestone::class,
            'ss_study_milestones_id'
        );
    }

    public function masterCategory()
    {
        return $this->belongsTo(
            SsMilestoneCategory::class,
            'ss_milestone_category_id'
        );
    }

    public function tasks()
    {
        return $this->hasMany(
            SsStudyMilestoneCategoryTask::class,
            'ss_study_milestone_category_id'
        );
    }
}
