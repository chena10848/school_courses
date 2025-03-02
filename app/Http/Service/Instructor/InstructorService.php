<?php

namespace App\Http\Service\Instructor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Response\Response;
use App\Http\Repository\Instructor\InstructorRepository;

class InstructorService {

    public function __construct(
        private InstructorRepository $instructorRepository,
        private Response $response
    ) {}

    public function queryInstructorList() {

        $instructorList = $this->instructorRepository->findUser();

        return collect($instructorList)->map(function ($instructor) {
            return [
                'instructorId' => $instructor->instructorId,
                'name' => $instructor->name,
                'email' => $instructor->email,
            ];
        })->toArray();
    }

    public function queryInstructorCourseList(int $instructorId) {
        $instructorCourseList = $this->instructorRepository->findUserAndCoursesByUserId($instructorId);

        return collect($instructorCourseList)->map(function ($instructorCourse) {
            return [
                'courseId' => $instructorCourse->courseId,
                'courseName' => $instructorCourse->courseName,
            ];
        })->toArray();
    }

    public function createInstructor($request) {

        try {
            DB::beginTransaction();

            $name = $request['name'];
            $email = $request['email'];
    
            $userId = $this->instructorRepository->createUser($name, $email);
    
            DB::commit();

            return [
                'instructorId' => $userId,
                'name' => $name,
                'email' => $email
            ];
        } catch (Exception $e) {
            DB::rollBack();

            $this->response->fail($e->getMessage());
        }
    }
}