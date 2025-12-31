<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsMilestoneCategoryTask extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ss_milestone_category_tasks';

    protected $fillable = [
        'ss_milestone_categories_id',
        'study_setup_type',
        'completion_type',
        'name',
        'order',
        'is_active',
    ];

    protected $casts = [
        'order'     => 'integer',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(SsMilestoneCategory::class, 'ss_milestone_categories_id');
    }
}
