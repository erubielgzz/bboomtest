<?php

use Illuminate\Database\Seeder;

use App\Models\NoteFolder;

class NotesFoldersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $folders = array(
            ['name' => 'Folder A'],
            ['name' => 'Folder B'],
        );

        foreach($folders as $folder){
            $nf = new NoteFolder;
            $nf->name = $folder['name'];
            $nf->save();
        }
    }
}
