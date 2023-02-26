<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    protected $category;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->category = $categoryRepository;
    }

    public function index()
    {
        return $this->category->getAllCategories();
    }

    public function show($id)
    {
        return $this->category->showCategories($id);
    }

    public function searchProduct($id,$search)
    {
        return $this->category->searchProduct($id,$search);
    }
}
