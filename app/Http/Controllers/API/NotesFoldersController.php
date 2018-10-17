<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\NoteFolder as NoteFolder;
use App\Http\Resources\NoteFolderResource;


class NotesFoldersController extends Controller
{
    public function index()
    {
        return NoteFolderResource::collection(NoteFolder::all());
    }
}
