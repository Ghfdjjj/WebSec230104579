<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_name',
        'grade',
        'credit_hours',
        'term',
    ];

    /**
     * Validation rules for creating or updating a grade.
     *
     * @return array
     */
    public static function rules()
    {
        return [
            'course_name' => 'required|string|max:255',
            'grade' => 'required|string|max:2', // Assuming grades are like A, B, C, etc.
            'credit_hours' => 'required|integer|min:1',
            'term' => 'required|string|max:255',
        ];
    }
}