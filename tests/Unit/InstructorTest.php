<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Service\Instructor\InstructorService;
use App\Http\Repository\Instructor\InstructorRepository;
use App\Http\Response\Response;

class InstructorTest extends TestCase {

    protected $instructorService;
    protected $instructorRepositoryMock;
    protected $responseMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->responseMock = $this->createMock(Response::class);

        $this->instructorRepositoryMock = $this->createMock(InstructorRepository::class);

        $this->instructorService = new InstructorService($this->instructorRepositoryMock, $this->responseMock);
    }

    public function testInstructorListSuccess()
    {
        // 定義模擬的資料
        $mockInstructorData = [
            (object) ['instructorId' => 1, 'name' => '小明', 'email' => 'test1@gmail.com'],
            (object) ['instructorId' => 2, 'name' => '小美', 'email' => 'test2@gmail.com'],
        ];

        // 設定 mock 方法返回資料
        $this->instructorRepositoryMock
            ->method('findUser')
            ->willReturn($mockInstructorData);

        // 執行 Service 方法
        $result = $this->instructorService->queryInstructorList();

        // 驗證結果
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]['instructorId']);
        $this->assertEquals('小明', $result[0]['name']);
        $this->assertEquals('test1@gmail.com', $result[0]['email']);
    }

    public function testInstructorCourseListSuccess()
    {
        $instructorId = 1;

        // 定義模擬的資料
        $mockInstructorCourseData = [
            (object) ['courseId' => 1, 'courseName' => 'PHP 程式設計'],
            (object) ['courseId' => 2, 'courseName' => 'PHP 程式設計(2)'],
        ];

        // 設定 mock 方法返回資料
        $this->instructorRepositoryMock
            ->method('findUserAndCoursesByUserId')
            ->with($instructorId)
            ->willReturn($mockInstructorCourseData);

        // 執行 Service 方法
        $result = $this->instructorService->queryInstructorCourseList($instructorId);

        // 驗證結果
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]['courseId']);
        $this->assertEquals('PHP 程式設計', $result[0]['courseName']);
    }
}
