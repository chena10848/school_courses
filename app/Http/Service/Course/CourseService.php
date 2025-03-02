<?php

namespace App\Http\Service\Course;

use Illuminate\Support\Facades\DB;
use App\Http\Repository\Course\CourseRepository;
use App\Http\Repository\Instructor\InstructorRepository;

class CourseService {

    public function __construct(
        private CourseRepository $courseRepositroy,
        private InstructorRepository $instructorRepository
    ) {}

    public function queryCourseList() {
        $courseList = $this->courseRepositroy->findCoursesAndUser();

        return collect($courseList)->map(function ($course) {
            return [
                'courseId' => $course->courseId,
                'courseName' => $course->courseName,
                'description' => $course->description,
                'startTime' => $course->startTime,
                'endTime' => $course->endTime,
                'instructor' => [
                    'instructorId' => $course->instructorId,
                    'name' => $course->name,
                    'email' => $course->email,
                ],
            ];
        })->toArray();
    }

    public function createCourse($request) {
        try {

            DB::beginTransaction();

            $courseName = $request['courseName'];
            $description = $request['description'];
            $startTime = $request['startTime'];
            $endTime = $request['endTime'];
            $instructorId = $request['instructorId'];

            $user = $this->instructorRepository->findUserById($instructorId);

            if($user->instructorId == null) {
                return $this->response->fail('user not found');
            }

            $courseId = $this->courseRepositroy->createCourse (
                $courseName,
                $description,
                $startTime,
                $endTime,
                $instructorId
            );

            DB::commit();

            return [
                'courseId' => $courseId,
                'courseName' => $courseName,
                'description' => $description,
                'startTime' => $startTime, 
                'endTime' => $endTime, 
                'instructorId' => $instructorId
            ];

        } catch (Exception $e) {
            DB::rollBack();

            return $this->response->fail($e->getMessage());
        }
    }

    public function updateCourse($request) {
        try {

            DB::beginTransaction();

            $courseId = $request['courseId'];
            $courseName = $request['courseName'];
            $description = $request['description'];
            $startTime = $request['startTime'];
            $endTime = $request['endTime'];
            $instructorId = $request['instructorId'];

            $courseList = $this->courseRepositroy->findCoursesById($courseId);

            if($courseList->courseId == null) {
                return $this->response->fail('courses not found');
            }

            $user = $this->instructorRepository->findUserById($instructorId);

            if($user->instructorId == null) {
                return $this->response->fail('user not found');
            }

            $updateData = [];

            if ($courseName !== null) {
                $updateData['courseName'] = $courseName;
            }
    
            if ($description !== null) {
                $updateData['description'] = $description;
            }
    
            if ($startTime !== null) {
                $updateData['startTime'] = $startTime;
            }
    
            if ($endTime !== null) {
                $updateData['endTime'] = $endTime;
            }
    
            if ($instructorId !== null) {
                $updateData['instructorId'] = $instructorId;
            }
    
            if (empty($updateData)) {
                return $this->response->fail('No data was updated');
            }

            $this->courseRepository->updateCourse($courseId, $updateData);

            DB::commit();

            $updateData['courseId'] = $courseId;

            return $updateData;

        } catch (Exception $e) {
            DB::rollBack();

            return $this->response->fail($e->getMessage());
        }
    }

    public function deleteCourse(int $courseId)
    {
        try {

            DB::beginTransaction();

            $courseList = $this->courseRepositroy->findCoursesById($courseId);

            if($courseList->courseId == null) {
                return $this->response->fail('courses not found');
            }

            $this->courseRepositroy->deleteCourse($courseId);

            DB::commit();

            return [
                'courseId' => $courseId
            ];

        } catch (Exception $e) {
            DB::rollBack();

            return $this->response->fail($e->getMessage());
        }
    }
}