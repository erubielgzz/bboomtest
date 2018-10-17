<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Note::class, function (Faker $faker) {

    if(rand(0,9) < 6){
        $note_folder = null;
    }else{
        $aux_folder = DB::table('note_folder')
                        ->inRandomOrder()
                        ->first();
        $note_folder = $aux_folder->id;
    }

    $aux_content = $faker->paragraphs(rand(2,5));

    return [
        'title' => substr($aux_content[0], 0, 180),
        'subtitle' => substr($aux_content[1], 0, 180),
        'content' => implode("<br />", $aux_content),
        'color' => $faker->hexcolor,
        'note_folder_id' => $note_folder,
    ];
});
