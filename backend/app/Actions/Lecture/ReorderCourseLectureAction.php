<?php

namespace App\Actions\Lecture;

use App\Models\Course;

class ReorderCourseLectureAction
{

    public static function run(Course $course)
    {
        $lectures = $course->lectures()
            ->join('sections', 'sections.id', '=', 'lectures.section_id')
            ->orderBy('lectures.sort_order')
            ->select('lectures.*')
            ->get();

        $lectures->each(function ($lecture, $index) {
            $lecture->update([
                'sort_order' => $index + 1
            ]);
        });
    }
}
