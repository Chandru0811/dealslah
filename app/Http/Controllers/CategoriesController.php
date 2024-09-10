<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $Category = Category::all();

        return $this->success('Category retrieved successfully.', $Category);
    }

    public function restore($id)
    {
        $Category = Category::onlyTrashed()->find($id);

        if (!$Category) {
            return $this->error('Category Not Found.', ['error' => 'Category Not Found']);
        }
        $Category->restore();

        return $this->success('Category restored successfully!', $Category);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_group_id' => 'required|exists:category_groups,id',
            'name'              => 'required|string|max:200',
            'slug'              => 'required|string|max:200|unique:categories,slug',
            'description'       => 'nullable|string',
            'active'            => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $category = Category::create($validatedData);

        return $this->success('Category Created Successfully!', $category);
    }

    // Show details of a single category
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return $this->success('Category Retrieved Successfully!', $category);
    }

    // Update an existing category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'category_group_id' => 'required|exists:category_groups,id',
            'name'              => 'required|string|max:200',
            'slug'              => 'required|string|max:200|unique:categories,slug,' . $id,
            'description'       => 'nullable|string',
            'active'            => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $category->update($validatedData);

        return $this->success('Category Updated Successfully!', $category);
    }

    // Soft delete a category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return $this->success('Category Deleted Successfully!', $category);
    }
}
