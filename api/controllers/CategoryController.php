<?php

namespace Api\Controllers;
use Api\Services\CategoryService;

class CategoryController 
{
    public function __construct(private CategoryService $categoryService)
    {

    }

    public function index()
    {
        return [
            'message' => 'Categories retrieved successfully',
            'code' => 200,
            'status' => 'success with payload',
            'categories' => $this->categoryService->getAll()
        ];
    }

    public function show(string $id)
    {

        $category = $this->categoryService->findById($id);
        
        if(!isset($category)) {
            http_response_code(404);

            return [
                'message' => 'Category was deleted or not found',
                'code' => 404,
                'status' => 'Not found'
            ];
        }

        return [
            'message' => 'Categories found successfully',
            'code' => 200,
            'status' => 'success with payload',
            'category' => $category
        ];
    }
}
