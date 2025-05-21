<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'base64',
        'mime_type',
        'alt',
        'order',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'order' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Геттер для получения полной data URI
    public function getDataUriAttribute(): string
    {
        return 'data:' . $this->mime_type . ';base64,' . $this->base64;
    }
}
