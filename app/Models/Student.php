<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use hasFactory;

    use SoftDeletes;
    protected $table = 'student';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'language',
    ];

    
}
