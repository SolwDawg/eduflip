<?php

namespace App\Actions\Course;

use App\Models\Course;

class GetInstructorCurriculumAction
{

    public static function run(Course $course)
    {
        return $course->fresh()->load(['sections', 'sections.lectures']);
    }
}
