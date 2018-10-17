<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Http\Controllers\Controller;

use App\Models\Image as Image;
use App\Http\Resources\ImageResource;

use DB;
use Validator;
use Storage;

class ImagesController extends Controller
{

    public function index()
    {
        return ImageResource::collection(Image::paginate(6));
    }

    public function getImage($id)
    {
        return new ImageResource(Image::findOrFail($id));
    }

    public function upload(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,bmp,png,gif,jpg,svg|max:4096',
        ]);

        if ($validator->fails()) {
	        $data['estatus'] = 'error';
	        $data['errors'] = $validator->errors();
 			return response()->json($data, 400);
        }

	    DB::beginTransaction();

        $image_file = $request->file('image');

	   	$file_path = time() . str_replace(' ', '_', $image_file->getClientOriginalName());

        $access_path = Storage::disk('public')->putFile('img', $image_file);

        $image = new Image;
        $image->path = 'storage/' . $access_path;
		$image->save();

		DB::commit();

        $data['image'] = $this->getImage($image->id);

		return response()->json($data, 200);
    }

    public function delete($id){

        $image = Image::findOrFail($id);
        Storage::disk('public')->delete(str_replace('storage/', '', $image->path));
        $image->delete();

        $data['status'] = "deleted";

        return response()->json($data);
    }

}
