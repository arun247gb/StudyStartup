<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SsSite extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ss_organizations_id',
        'name',
        'site_number',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country',
        'irb_name',
        'is_active',
        'activation_date',
        'activation_letter_document_id',
    ];

    public function organization()
    {
        return $this->belongsTo(SsOrganization::class, 'ss_organizations_id');
    }
}
