<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $tags = ['Sport' => 'primary', //blau
        'Entspannung' => 'secondary', //grau-grau
        'Fun' => 'warning', //gelb
        'Natur' => 'success', //grün
        'Inspiration' => 'light', //weiß-grau
        'Freunde' => 'info', //türkis
        'Liebe' => 'danger', //rot
        'Interesse' => 'dark' //schwarz-weiß
        ];

        foreach ($tags as $key => $value) {
            $tag = new Tag(
                [
                    'name' => $key,
                    'style' => $value
                ]
            );
            $tag->save();
        }
    }
}
