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

    $sum_date_1 = rand(0,3);

	$created_at = $faker->dateTimeBetween($startDate = '-60 days', $endDate = '-3 days', $timezone = 'America/Monterrey');
	$updated_at = date('Y-m-d H:i:s',strtotime($created_at->format('Y-m-d H:i:s') . "+" . $sum_date_1 . " days"));

    return [
        'title' => substr($aux_content[0], 0, 180),
        'subtitle' => substr($aux_content[1], 0, 180),
        'content' => implode("<br />", $aux_content),
        'color' => $faker->randomElement(['#FFFFFF', '#F5A9A9', '#F5D0A9', '#F2F5A9', '#A9F5A9', '#A9F5F2', '#A9D0F5', '#F5A9F2']),
        'note_folder_id' => $note_folder,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
