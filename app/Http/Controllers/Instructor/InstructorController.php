<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Response\Response;
use App\Http\Service\Instructor\InstructorService;

use App\Http\Requests\Instructor\CreateInstructor;

class InstructorController extends Controller
{
    public function __construct(
        private InstructorService $instructorService,
        private Response $response
    ) {}

    public function instructorList() {
        $instructorList = $this->instructorService->queryInstructorList();
        return $this->response->success($instructorList);
    }

    public function instructorCourseList(int $instructorId) {
        $instructorCourseList = $this->instructorService->queryInstructorCourseList($instructorId);
        return $this->response->success($instructorCourseList);
    }

    public function createInstructor(CreateInstructor $request) {
        $createInstructor = $this->instructorService->createInstructor($request->validated());
        return $this->response->success($createInstructor);
    }
}
