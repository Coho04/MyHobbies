<?php

namespace Database\Seeders;

use App\Models\Hobby;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        User::factory(100)->create()->each(function ($user) {
            Hobby::factory(rand(1, 8))->create(
                [
                    'user_id' => $user->id
                ]
            )->each(function ($hobby) {
                $tag_ids = range(1, 8);
                shuffle($tag_ids);
                $verknuepfungen = array_slice($tag_ids, 0, rand(0, 8));
                foreach ($verknuepfungen as $value) {
                    DB::table('hobby_tag')->insert(
                        [
                            'hobby_id' => $hobby->id,
                            'tag_id' => $value,
                            'created_at' => Now(),
                            'updated_at' => Now()
                        ]
                    );
                }
            });
        });
    }
}
