<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';

    public function models(): BelongsToMany
    {
        return $this->belongsToMany(Model3D::class, 'tags_pivot', 'tag_id', 'model_id');
    }
}
