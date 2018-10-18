<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'note';

    public function folder()
    {
        return $this->belongsTo('App\Models\NoteFolder', 'note_folder_id', 'id');
    }

}
