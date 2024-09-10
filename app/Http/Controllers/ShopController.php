<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\ApiResponses;

class ShopController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $shops = Shop::all();
        return $this->success('Shops Retrived Succesfully!', $shops);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'legal_name' => 'required|string',
            'slug' => 'required|unique:shops,slug',
            'email' => 'required|email|unique:shops,email,',
            'description' => 'required|string',
            'external_url' => 'required|url',
            'address' => 'required|string',
            'ph_number' => 'required|string',
            'email_id' => 'required|email|unique:shops,email_id,',
        ], [
            'name.required' => 'The name field is required.',
            'legal_name.required' => 'The legal name field is required.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'The slug must be unique.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email must be unique.',
            'description.required' => 'The description field is required.',
            'external_url.required' => 'The external url field is required.',
            'external_url.url' => 'The external URL must be a valid URL.',
            'address.required' => 'The address field is required.',
            'ph_number.required' => 'The phone number field is required.',
            'email_id.required' => 'The email id field is required.',
            'email_id.email' => 'The email id must be a valid email address.',
            'email_id.unique' => 'The email id must be unique.',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error.', ['errors' => $validator->errors()]);
        }

        $shop = Shop::create($request->all());
        return $this->success('Shop Created Succesfully!', $shop);
    }

    public function show(string $id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return $this->error('Shop Not Found.', ['error' => 'Shop Not Found']);
        }
        return $this->success('Shop Retrived Succesfully!', $shop);
    }

    public function update(Request $request, string $id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return $this->error('Shop Not Found.', ['error' => 'Shop Not Found']);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'legal_name' => 'required|string',
            'slug' => 'required|unique:shops,slug,' . $id,
            'email' => 'required|email|unique:shops,email,' . $id,
            'description' => 'required|string',
            'external_url' => 'required|url',
            'address' => 'required|string',
            'ph_number' => 'required|string',
            'email_id' => 'required|email|unique:shops,email_id,' . $id,
        ], [
            'name.required' => 'The name field is required.',
            'legal_name.required' => 'The legal name field is required.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'The slug must be unique.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email must be unique.',
            'description.required' => 'The description field is required.',
            'external_url.required' => 'The external url field is required.',
            'external_url.url' => 'The external URL must be a valid URL.',
            'address.required' => 'The address field is required.',
            'ph_number.required' => 'The phone number field is required.',
            'email_id.required' => 'The email id field is required.',
            'email_id.email' => 'The email id must be a valid email address.',
            'email_id.unique' => 'The email id must be unique.',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error.', ['errors' => $validator->errors()]);
        }

        $shop->update($request->all());
        return $this->success('Shop Updated Succesfully!', $shop);
    }

    public function destroy($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return $this->error('Shop Not Found.', ['error' => 'Shop Not Found']);
        }

        $shop->delete();
        return $this->ok('Shop Deleted Succesfully!');
    }

    public function restore($id)
    {
        $shop = Shop::onlyTrashed()->find($id);

        if (!$shop) {
            return $this->error('Shop Not Found.', ['error' => 'Shop Not Found']);
        }

        $shop->restore();
        return $this->success('Shop Restored Succesfully!', $shop);
    }

    // Permanently delete a shop
    public function forceDelete($id)
    {
        $shop = Shop::onlyTrashed()->find($id);

        if (!$shop) {
            return $this->error('Shop Not Found.', ['error' => 'Shop Not Found'], 404);
        }

        $shop->forceDelete();
        return response()->json([
            'message' => 'Shop Permanently Deleted Successfully!',
            'status' => 204
        ]);
    }

}