<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Note as Note;
use App\Http\Resources\NoteResource;

use DB;
use Validator;

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

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:2',
        ]);

        if ($validator->fails()) {
	        $data['errors'] = $validator->errors();
 			return response()->json($data, 400);
        }

	    DB::beginTransaction();
        $note = Note::findOrFail($id);

        $auxArr = explode("<br>", $request->content);

        $title = substr(strip_tags(html_entity_decode($auxArr[0])), 0, 200);

        $subtitle="";
        if(sizeof($auxArr) >= 2){
            array_shift($auxArr);
            $subtitle = substr(strip_tags(html_entity_decode(implode('<br>', $auxArr))), 0, 200);
        }

        $note->title = $title;
        $note->subtitle = $subtitle;
        $note->content = $request->content;
        $note->color = $request->color;
        $note->note_folder_id = ( $request->note_folder_id ? $request->note_folder_id : NULL);
		$note->update();

		DB::commit();

        $data['note'] = $this->getNote($note->id);

		return response()->json($data, 200);
    }

    public function delete($id){

        $note = Note::findOrFail($id);
        $note->delete();

        $data['status'] = "deleted";

        return response()->json($data);
    }
}
