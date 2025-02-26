<?php

namespace App\Http\Controllers\Instructor;

use App\Actions\Category\GetAllCategoriesAction;
use App\Actions\Course\GetInstructorCourseAction;
use App\Actions\Course\GetInstructorCurriculumAction;
use App\Actions\Course\StoreCourseAction;
use App\Actions\Course\UpdateCourseAction;
use App\Actions\Course\UpdateCourseStatusAction;
use App\Actions\Course\UploadCourseImageAction;
use App\Data\Course\StoreCourseData;
use App\Data\Course\UpdateCourseData;
use App\Data\Course\UploadCourseImageData;
use App\Enums\CourseLevel;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CourseResource;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class InstructorCourseController extends Controller
{
    public function index()
    {
        $courses = GetInstructorCourseAction::run();

        return CourseResource::collection($courses);
    }

    public function store(StoreCourseData $data)
    {
        $course = StoreCourseAction::run($data);

        return CourseResource::make($course);
    }

    public function show(Course $course)
    {
        return CourseResource::make($course);
        // return CourseResource::make($course->load('author', 'category'));
    }

    public function getBasicInfo(Course $course)
    {
        return response()->json([
            'course' => CourseResource::make($course->load('category')),
            'categories' => CategoryResource::collection(GetAllCategoriesAction::run()),
            'levels' => CourseLevel::getArray(),
        ]);
    }

    public function updateBasicInfo(UpdateCourseData $data, Course $course)
    {
        $this->authorize('update', $course);
        $course = UpdateCourseAction::run($data, $course);
        return CourseResource::make($course->load('category'));
    }

    public function cover(UploadCourseImageData $data, Course $course)
    {
        $this->authorize('update', $course);
        $course = UploadCourseImageAction::run($data, $course);

        return CourseResource::make($course);
    }

    public function updateStatus(Course $course)
    {
        abort_unless($course->canBePublished(), 401, 'Course not ready for status change');

        UpdateCourseStatusAction::run($course);

        return CourseResource::make($course->fresh());
    }

    public function curriculum(Course $course)
    {
        $this->authorize('update', $course);
        $data = GetInstructorCurriculumAction::run($course);

        return CourseResource::make($data);
    }

}
