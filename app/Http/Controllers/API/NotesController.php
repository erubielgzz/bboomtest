<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Note as Note;
use App\Http\Resources\NoteResource;

use DB;

class NotesController extends Controller
{
    public function index(Request $request)
    {
        $q = Note::query();
        if($request->folder != null && $request->folder != "no-folder"){
            $q->where('note_folder_id', $request->folder);
        }else if($request->folder == "no-folder"){
            $q->whereNull('note_folder_id');
        }

        if($request->search != null){
            $q->whereRaw("content LIKE '%" . $request->search . "%'");
        }

        $notes = $q->orderBy('updated_at', 'desc')->get();
        return NoteResource::collection($notes);
    }

    public function getNote($id)
    {
        return new NoteResource(Note::findOrFail($id));
    }

    public function createNew(Request $request)
    {
	    DB::beginTransaction();

        $note = new Note;
		$note->save();

		DB::commit();

        $data['note'] = $this->getNote($note->id);

		return response()->json($data, 200);
    }
}
