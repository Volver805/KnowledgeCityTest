<?php
namespace Api\Controllers;

use Api\Services\CourseService;

class CourseController
{
    public function __construct(private CourseService $courseService)
    {

    }
    public function index()
    {
        if(isset($_GET['category_id'])) { 
            return [
                'message' => 'Courses retrieved successfully',
                'code' => 200,
                'status' => 'success with payload',
                'courses' => $this->courseService->getCoursesByCategory($_GET['category_id'])
            ];
        }

        return [
            'message' => 'Courses retrieved successfully',
            'code' => 200,
            'status' => 'success with payload',
            'courses' => $this->courseService->getAllCourses()
        ];
    }

    public function show(string $id)
    {
        $course = $this->courseService->getCourseById($id);
        
        if(!isset($course)) {
            http_response_code(404);

            return [
                'message' => 'Course was deleted or not found',
                'code' => 404,
                'status' => 'Not found'
            ];
        }

        return [
            'message' => 'Course found successfully',
            'code' => 200,
            'status' => 'success with payload',
            'course' => $course
        ];
    }
}