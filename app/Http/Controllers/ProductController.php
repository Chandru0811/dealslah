<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    use ApiResponses;

    public function index()
    {
        $products = Product::all();

        return $this->success( 'Products retrieved successfully.',$products);
    }

    public function restore($id)
{
    $product = Product::onlyTrashed()->find($id);

    if (!$product) {
        return $this->error('Product Not Found.', ['error' => 'Product Not Found']);
    }
    $product->restore();

    return $this->success('Product restored successfully!', $product);
}


    public function store(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(),[
            'shop_id' => 'required|string',
            'brand' => 'required|string|max:255',
            'category_id' => 'required|string',
            'description' => 'required|string',
            'slug' => 'required|string|unique:products,slug',
            'original_price' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'image_url' => 'nullable|url', 
            'active' => 'nullable|boolean',
            "end_date"=> 'nullable|date',
            "start_date"=> 'nullable|date'
        ], [
            'image.required' => 'The image is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a jpeg, png, jpg, gif, or svg file.',
            'image.max' => 'The image must not be larger than 2MB.',
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Retrieve validated data
        $validatedData = $validator->validated();
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'assets/products';
    
            if (!file_exists($imagePath)) {
                mkdir($imagePath, 0755, true);
            }
    
            $image->move($imagePath, $imageName);
    
            // Add image URL to the validated data
            $validatedData['image_url'] = $imagePath . "/" . $imageName;
        }
    // dd($validatedData);
        // Create product with validated data
        $products = Product::create($validatedData);
    
        return $this->success(
            'Product created successfully.',
            $products
        );
    }
    
    public function show(string $id)
    {
        $products = Product::find($id);
        if (!$products) {
            return $this->error('Product Not Found.', ['error' => 'Product Not Found']);
        }
        return $this->success('Product Retrived Succesfully!', $products);

    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'shop_id' => 'required|exists:shops,id',
            'brand' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'slug' => 'required|string|unique:products,slug,' . $id, 
            'original_price' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku,' . $id, 
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'active' => 'required|boolean',
            'end_date' => 'required|date',
            'start_date' => 'required|date',
        ], [
            'shop_id.exists' => 'The selected shop does not exist.',
            'category_id.exists' => 'The selected category does not exist.',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $products = Product::find($id);
        if (!$products) {
            return $this->error('Product Not Found.', ['error' => 'Product Not Found']);
        }
    
        $validatedData = $validator->validated();
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
    
            if ($image->isValid()) {
    
                $oldImagePath = public_path($products->path);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
    
                $imageName = time() . '_' . $image->getClientOriginalName();
                $publicPath = public_path("assets/products");
    
                if (!file_exists($publicPath)) {
                    File::makeDirectory($publicPath, 0777, true, true);
                }

                $image->move($publicPath, $imageName);

                $validatedData['image_url'] = pathinfo($imageName, PATHINFO_FILENAME);
                $validatedData['path'] = "assets/products/" . $imageName;
                $validatedData['name'] = $imageName;
                $validatedData['extension'] = $image->getClientOriginalExtension();

                $validatedData['size'] = filesize($publicPath . '/' . $imageName);
            } else {
                return $this->error('Uploaded file is not valid.', 422);
            }
        }

        $products->update($validatedData);

        return $this->success('Product Updated Successfully!', $products);
    }
        
    public function destroy(string $id)
    {
        $products = Product::findOrFail($id);
        $products->delete();
        return $this->ok('Product Deleted Successfully!');
    }
}
