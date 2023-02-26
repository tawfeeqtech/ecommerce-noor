<?php

namespace App\Repository\Category;

interface CategoryRepositoryInterface{
    public function getAllCategories();
    public function showCategories($id);
    public function searchProduct($id,$request);

}
