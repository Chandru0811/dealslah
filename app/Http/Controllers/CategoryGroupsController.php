<?php

namespace App\Http\Controllers;

use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Validator;

class CategoryGroupsController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $categoryGroup = CategoryGroup::all();

        return $this->success('Category Group retrieved successfully.', $categoryGroup);
    }

    public function restore($id)
    {
        $categoryGroup = CategoryGroup::onlyTrashed()->find($id);

        if (!$categoryGroup) {
            return $this->error('Category Group Not Found.', ['error' => 'categoryGroup Not Found']);
        }
        $categoryGroup->restore();

        return $this->success('Category Group restored successfully!', $categoryGroup);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:200',
            'slug'        => 'required|string|max:200|unique:category_groups,slug',
            'description' => 'required|string',
            'icon'        => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active'      => 'nullable|boolean',
            'order'       => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imagePath = $image->storeAs('public/images/category_groups', time() . '-' . $image->getClientOriginalName());
            $validatedData['icon'] = $imagePath;
        }

        $categoryGroup = CategoryGroup::create($validatedData);

        return $this->success('CategoryGroup Created Successfully!', $categoryGroup);
    }


    public function show($id)
    {

        $categoryGroup = CategoryGroup::find($id);


        if (!$categoryGroup) {
            return $this->error('Category Group Not Found.', ['error' => 'Category Group Not Found']);
        }

        return $this->success('Category Group view Succesfully!', $categoryGroup);
    }

    public function update(Request $request, $id)
    {
        $categoryGroup = CategoryGroup::find($id);

        if (!$categoryGroup) {
            return $this->error('Category Group Not Found.', ['error' => 'Category Group Not Found']);
        }
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:200' . $id,
            'slug'        => 'required|string|max:200|unique:category_groups,slug,' . $id,
            'description' => 'required|string',
            'icon'        => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active'      => 'nullable|boolean',
            'order'       => 'required|integer'
        ], [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name must be unique.',
            'name.max' => 'The name may not be greater than 200 characters.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'The slug must be unique.',
            'slug.max' => 'The slug may not be greater than 200 characters.',
            'description.required' => 'The description field is required.',
            'order.required' => 'The order field is required.',
            'order.integer' => 'The order field must be an integer.',
            'icon.file' => 'The icon must be a file.',
            'icon.mimes' => 'The icon must be a file of type: jpeg, png, jpg, gif, svg.',
            'icon.max' => 'The icon may not be greater than 2048 kilobytes.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imagePath = $image->storeAs('public/images/category_groups', time() . '-' . $image->getClientOriginalName());
            $validatedData['icon'] = $imagePath;
        }

        $categoryGroup->update($validatedData);

        return $this->success('Category Group Updated Successfully!', $categoryGroup);
    }

    public function delete($id)
    {
        $categoryGroup = CategoryGroup::find($id);

        if (!$categoryGroup) {
            return $this->error('Category Group Not Found.', ['error' => 'Category Group Not Found']);
        }

        $categoryGroup->delete();
        return $this->success('Category Group Deleted Successfully!', $categoryGroup);
    }
}
