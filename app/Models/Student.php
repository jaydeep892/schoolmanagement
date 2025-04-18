<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name', 'email', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id', 'id');
    }
}
