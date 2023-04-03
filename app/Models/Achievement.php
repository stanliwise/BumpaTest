<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    public function next_achievement()
    {
        return Achievement::where('parent_id', $this->id)->first();
    }

    public function previous_achievement()
    {
        return Achievement::where('id', $this->parent_id)->first();
    }
}
