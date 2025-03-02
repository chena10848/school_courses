<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Service\Course\CourseService;
use App\Http\Repository\Course\CourseRepository;
use App\Http\Repository\Instructor\InstructorRepository;
use App\Http\Response\Response;

class CourseTest extends TestCase {

    protected $courseService;
    protected $courseRepositoryMock;
    protected $instructorRepositoryMock;
    protected $responseMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->responseMock = $this->createMock(Response::class);

        $this->courseRepositoryMock = $this->createMock(CourseRepository::class);

        $this->instructorRepositoryMock = $this->createMock(InstructorRepository::class);

        $this->courseService = new CourseService(
            $this->courseRepositoryMock,
            $this->instructorRepositoryMock,
            $this->responseMock
        );
    }

    public function testQueryCourseListSuccess()
    {
        // 定義模擬的資料
        $mockCourseData = [
            (object) [
                'courseId' => 1,
                'courseName' => 'PHP 程式設計',
                'description' => '學習 PHP 基礎',
                'startTime' => '0900',
                'endTime' => '1200',
                'instructorId' => 1,
                'name' => '小明',
                'email' => 'test1@gmail.com',
            ],
            (object) [
                'courseId' => 2,
                'courseName' => 'Python 程式設計',
                'description' => '學習 Python 基礎',
                'startTime' => '0900',
                'endTime' => '1200',
                'instructorId' => 2,
                'name' => '小美',
                'email' => 'test2@gmail.com',
            ],
        ];

        // 設定 mock 方法返回資料
        $this->courseRepositoryMock
            ->method('findCoursesAndUser')
            ->willReturn($mockCourseData);

        // 執行 Service 方法
        $result = $this->courseService->queryCourseList();

        // 驗證結果
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]['courseId']);
        $this->assertEquals('PHP 程式設計', $result[0]['courseName']);
        $this->assertEquals('學習 PHP 基礎', $result[0]['description']);
        $this->assertEquals('0900', $result[0]['startTime']);
        $this->assertEquals('1200', $result[0]['endTime']);
        $this->assertEquals(1, $result[0]['instructor']['instructorId']);
        $this->assertEquals('小明', $result[0]['instructor']['name']);
        $this->assertEquals('test1@gmail.com', $result[0]['instructor']['email']);

        $this->assertEquals(2, $result[1]['courseId']);
        $this->assertEquals('Python 程式設計', $result[1]['courseName']);
        $this->assertEquals('學習 Python 基礎', $result[1]['description']);
        $this->assertEquals('0900', $result[1]['startTime']);
        $this->assertEquals('1200', $result[1]['endTime']);
        $this->assertEquals(2, $result[1]['instructor']['instructorId']);
        $this->assertEquals('小美', $result[1]['instructor']['name']);
        $this->assertEquals('test2@gmail.com', $result[1]['instructor']['email']);
    }
}