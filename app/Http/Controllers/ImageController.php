<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;
use app\Http\Requests;

class ImageController extends Controller
{
    public function imageUpload()
    {
    	return view('image-upload');
    }

    /**
    * Manage Post Request
    *
    * @return void
    */
    public function imageUploadPost(Request $request)
    {
    	$this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('pics'), $imageName);

    	return back()
    		->with('success','Image Uploaded successfully.')
    		->with('path',$imageName);
    }
}
