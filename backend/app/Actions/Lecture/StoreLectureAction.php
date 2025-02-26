<?php

namespace App\Actions\Lecture;

use App\Data\Lecture\CourseLectureData;
use App\Models\Course;
use App\Models\Section;

class StoreLectureAction
{

    public static function run(CourseLectureData $data, Section $section)
    {
        $max_sort = $section->lectures()->max('sort_order');

        return $section->lectures()->create([
            'course_id' => $section->course_id,
            'title' => $data->title,
            'sort_order' => $max_sort + 1,
        ]);


    }
}
