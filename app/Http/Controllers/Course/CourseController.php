<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Response\Response;
use App\Http\Service\Course\CourseService;

use App\Http\Requests\Course\CreateCourse;
use App\Http\Requests\Course\UpdateCourse;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService,
        private Response $response
    ) {}

    public function courseList() {
        $courseList = $this->courseService->queryCourseList();
        return $this->response->success($courseList);
    }

    public function createCourse(CreateCourse $request) {
        $createCourse = $this->courseService->createCourse($request->validated());
        return $this->response->success($createCourse);
    }

    public function updateCourse(UpdateCourse $request) {
        $updateCourse = $this->courseService->updateCourse($request->validated());
        return $this->response->success($updateCourse);
    }

    public function deleteCourse(int $courseId) {
        $deleteCourse = $this->courseService->deleteCourse($courseId);
        return $this->response->success($deleteCourse);
    }
}
