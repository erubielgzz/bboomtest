<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Note as Note;
use App\Http\Resources\NoteResource;

class NotesController extends Controller
{
    public function index()
    {
        return NoteResource::collection(Note::all());
    }
}
