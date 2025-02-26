<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Lecture\DeleteLectureAction;
use App\Actions\Lecture\ReorderCourseLectureAction;
use App\Actions\Lecture\StoreLectureAction;
use App\Actions\Lecture\UpdateLectureAction;
use App\Data\Lecture\CourseLectureData;
use App\Http\Controllers\Controller;
use App\Http\Resources\LectureResource;
use App\Http\Resources\SectionResource;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Section;

class InstructorLectureController extends Controller
{
    public function store(CourseLectureData $data, Course $course, Section $section)
    {
        $this->authorize('update', $course);
        $lecture = StoreLectureAction::run($data, $section);

        ReorderCourseLectureAction::run($course);

        return LectureResource::make($lecture->fresh());
    }

    public function update(CourseLectureData $data, Course $course, Lecture $lecture)
    {
        $this->authorize('update', $course);
        $lecture = UpdateLectureAction::run($data, $lecture);

        return LectureResource::make($lecture->fresh());
    }

    public function destroy(Course $course, Lecture $lecture)
    {
        $this->authorize('update', $course);
        DeleteLectureAction::run($lecture);
        ReorderCourseLectureAction::run($course);

        return SectionResource::collection($course->sections->load('lectures'));
    }
}
