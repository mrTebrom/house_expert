<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    protected $fillable = [
        'project_code',
        'title',
        'category_id',
        'total_area',
        'dimensions',
        'floors',
        'has_basement',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
