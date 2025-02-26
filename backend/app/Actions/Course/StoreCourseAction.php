<?php

namespace App\Actions\Course;

use App\Data\Course\StoreCourseData;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreCourseAction
{

    public static function run(StoreCourseData $data)
    {
        $course = Course::create([
            'user_id' => Auth::id(),
            'title' => $data->title,
            // 'slug' => Str::slug($data->title),
            'subtitle' => $data->subtitle,
            'category_id' => Category::getId($data->category),
            'subcategory_id' => Category::getId($data->subcategory),
        ]);

        $section = $course->sections()->create([
            'title' => 'Start here',
            'sort_order' => 1,
        ]);

        $section->lectures()->create([
            'course_id' => $course->id,
            'title' => 'Introduction',
            'sort_order' => 1,
        ]);

        return $course;
    }
}
