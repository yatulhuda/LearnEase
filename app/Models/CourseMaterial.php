<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model {
    protected $fillable = ['subject_code', 'week_title', 'title', 'type', 'description'];
}