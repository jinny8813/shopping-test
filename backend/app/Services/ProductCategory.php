<?php

namespace App\Services;

use App\Models\ProductsModel;

class ProductCategory
{
    public function buildCategoryTree(array $categories, $parentId = null)
    {
        $branch = [];
        $productsModel = new ProductsModel();

        foreach ($categories as $category) {
            if ($category['c_parent_id'] === $parentId) {
                $products = $productsModel->where('c_id', $category['c_id'])->findAll();
                $category['products'] = $products;

                $children = $this->buildCategoryTree($categories, $category['c_id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $branch[] = $category;
            }
        }

        return $branch;
    }
}
