<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectProgress extends Model
{
    protected $table = 'project_progress';

    protected $fillable = [
        'project_id',
        'period',
        'order_index',
        'planned_percentage',
        'actual_percentage',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
