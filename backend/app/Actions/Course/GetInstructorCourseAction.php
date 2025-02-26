<?php

namespace App\Actions\Course;

use Illuminate\Support\Facades\Auth;

class GetInstructorCourseAction
{

    public static function run()
    {
        return Auth::user()->courses;
    }
}
