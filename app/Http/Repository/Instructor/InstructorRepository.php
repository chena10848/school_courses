<?php

namespace App\Http\Repository\Instructor;

use Illuminate\Support\Facades\DB;

class InstructorRepository {
    public function __construct() {}

    public function findUser() {
        return DB::table('user')
            ->select(
            'user.id as instructorId',
            'user.name as name',
            'user.email as email'
        )->get()
        ->toArray();
    }

    public function findUserById(int $instructorId) {
        return DB::table('user')
            ->where('user.Id', $instructorId)
            ->select('user.id as instructorId')
            ->first();
    }

    public function findUserAndCoursesByUserId() {
        return DB::table('user')
            ->join('roles', 'user.roleId', 'roles.Id')
            ->join('courses', 'user.Id', 'courses.instructorId')
            ->where('roles.Id', 2)
            ->select(
                'courses.id as courseId',
                'courses.courseName as courseName'
            )->get()
            ->toArray();
    }

    public function createUser(string $name, string $email) {
        $userId = DB::table('user')
            ->insertGetId([
                'name' => $name,
                'email' => $email,
                'roleId' => 2,
                'status' => 1,
                'password' => 'hashedpassword3',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        return $userId;
    }
}