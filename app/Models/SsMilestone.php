<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsMilestone extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ss_milestones';

    protected $fillable = [
        'name',
        'order',
        'is_active',
        'milestone_owner_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function categories()
    {
        return $this->hasMany(SsMilestoneCategory::class, 'ss_milestone_id');
    }

}
