<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_site_id',
        'name',
        'quantity',
        'current_quantity',
    ];

    public function site()
    {
        return $this->belongsTo(ProjectSite::class, 'project_site_id');
    }
}
