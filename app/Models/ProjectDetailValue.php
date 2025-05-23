<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDetailValue extends Model
{
    protected $fillable = ['project_id', 'detail_field_id', 'value'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function field()
    {
        return $this->belongsTo(DetailField::class, 'detail_field_id');
    }
}
