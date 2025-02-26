<?php

namespace App\Data\Course;

use Spatie\LaravelData\Data;

class StoreCourseData extends Data
{
    public string $title;
    public string $subtitle;
    public string $category;
    public string $subcategory;

    public static function rules() : array
    {
        return [
            'title' => ['required', 'string'],
            'subtitle' => ['required', 'string'],
            'category' => ['required', 'exists:categories,hashid'],
            'subcategory' => ['required', 'exists:subcategories,hashid'],
        ];
    }
}

