<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'fiber_used',
    ];

    public function sites()
    {
        return $this->hasMany(ProjectSite::class);
    }
}
