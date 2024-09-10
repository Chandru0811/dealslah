<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    use ApiResponses;
    public function index()
    {
        $banners = Banner::all(); 
        return $this->success( 'Banner retrieved successfully.',$banners);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $banner = Banner::find($id);
        if (!$banner) {
            return $this->error('Banner Not Found.', ['error' => 'Banner Not Found']);
        }
        return $this->success('Banner Retrived Succesfully!', $banner);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return $this->ok('Banner Deleted Successfully!');
    }
}
