<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsMilestoneCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ss_milestone_categories';

    protected $fillable = [
        'ss_milestone_id',
        'category_name',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function milestone()
    {
        return $this->belongsTo(SsMilestone::class, 'ss_milestone_id');
    }

    public function tasks()
    {
        return $this->hasMany( SsMilestoneCategoryTask::class, 'ss_milestone_categories_id' );
    }

}
