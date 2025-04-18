<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    protected $fillable = ['name', 'email'];

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}
