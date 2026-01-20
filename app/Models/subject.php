<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    // Table name (optional if it follows convention, but good to be explicit)
    protected $table = 'subjects';

    // Allow these columns to be filled
    protected $fillable = [
        'subjectID',
        'subject_name',
    ];
}