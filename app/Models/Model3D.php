<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use phpDocumentor\Reflection\DocBlock\Tag;

class Model3D extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'last_edit', 'size'];

    protected $table = 'models';

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tags_pivot', 'model_id', 'tag_id');
    }
}
