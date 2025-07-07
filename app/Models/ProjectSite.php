<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'fiber_used',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function items()
    {
        return $this->hasMany(SiteItem::class);
    }
}
