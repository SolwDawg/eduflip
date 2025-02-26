<?php

namespace App\Data\Course;

use App\Enums\CourseLevel;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Data;

class UpdateCourseData extends Data
{
    public string $title;
    public string $subtitle;
    public string $description;
    public string $level;
    public string $category;
    public string $subcategory;

    public static function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'exists:categories,id'],
            'subcategory' => ['required', 'string', 'exists:categories,id'],
            'level' => ['required', 'string', Rule::in(CourseLevel::getArray())],
        ];
    }
}

