<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailField extends Model
{
    protected $fillable = ['label', 'type'];

    public function values()
    {
        return $this->hasMany(ProjectDetailValue::class, 'detail_field_id');
    }
}
