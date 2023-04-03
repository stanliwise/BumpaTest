<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    public function next_badge()
    {
        return static::where('parent_id', $this->id)->first();
    }

    public function previous_badge()
    {
        return static::where('id', $this->parent_id)->first();
    }
}
