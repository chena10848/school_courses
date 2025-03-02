<?php

namespace App\Http\Repository\Course;

use Illuminate\Support\Facades\DB;

class CourseRepository {

    public function __construct() {}

    public function findCoursesAndUser() {
        return DB::table('courses')
                ->join('user', 'courses.instructorId', 'user.id')
                ->select(
                    'courses.id as courseId',
                    'courses.courseName as courseName',
                    'courses.description as description',
                    'courses.startTime as startTime',
                    'courses.endTime as endTime',
                    'user.id as instructorId',
                    'user.name as name',
                    'user.email as email'
                )->get()
                ->toArray();
    }

    public function findCoursesById(int $courseId) {
        return DB::table('courses')
            ->where('id', $courseId)
            ->select('courses.id as courseId')
            ->first();
    }

    public function createCourse (
        string $courseName,
        string $description,
        string $startTime,
        string $endTime,
        int $instructorId
    ) {
        
        $courseId = DB::table('courses')
        ->insertGetId([
            'courseName' => $courseName,
            'description' => $description,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'instructorId' => $instructorId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $courseId;
    }

    public function updateCourse(int $courseId, array $updateData) {
        DB::table('courses')
            ->where('courses.Id', $courseId)
            ->update($updateData);
    }

    public function deleteCourse(int $courseId) {
        DB::table('courses')
            ->where('courses.Id', $courseId)
            ->delete();
    }
}