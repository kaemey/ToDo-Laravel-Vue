<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $table = 'todos';

    public function tags()
    {
        return $this->belongsToMany(Tag::class, "todos_tags", "todo_id", "tag_id");
    }
}