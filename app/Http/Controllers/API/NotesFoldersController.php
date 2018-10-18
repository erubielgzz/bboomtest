<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\NoteFolder as NoteFolder;
use App\Http\Resources\NoteFolderResource;

use DB;
use Validator;

class NotesFoldersController extends Controller
{
    public function index()
    {
        return NoteFolderResource::collection(NoteFolder::all());
    }

    public function getNotesFolder($id)
    {
        return new NoteFolderResource(NoteFolder::findOrFail($id));
    }

    public function createNew(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|unique:note_folder,name',
        ]);

        if ($validator->fails()) {
	        $data['errors'] = $validator->errors();
 			return response()->json($data, 400);
        }

	    DB::beginTransaction();

        $notes_folder = new NoteFolder;
        $notes_folder->name = $request->name;
		$notes_folder->save();

		DB::commit();

        $data['folder'] = $this->getNotesFolder($notes_folder->id);

		return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|unique:note_folder,name,'.$id,
        ]);

        if ($validator->fails()) {
	        $data['errors'] = $validator->errors();
 			return response()->json($data, 400);
        }

	    DB::beginTransaction();
        $notes_folder = NoteFolder::findOrFail($id);

        $notes_folder->name = $request->name;
		$notes_folder->update();

		DB::commit();

        $data['folder'] = $this->getNotesFolder($notes_folder->id);

		return response()->json($data, 200);
    }

    public function delete($id){

        $notes_folder = NoteFolder::findOrFail($id);
        $notes_folder->delete();

        $data['status'] = "deleted";

        return response()->json($data);
    }

}
