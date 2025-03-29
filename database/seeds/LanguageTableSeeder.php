<?php

use Illuminate\Database\Seeder;
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class LanguageTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('languages')->truncate();
        DB::table('languages')->insert([
            'language' => 'US English',
            'locale' => 'en'
        ]);

        DB::table('languages')->insert([
            'language' => 'Spanish',
            'locale' => 'es'
        ]);

        DB::table('languages')->insert([
            'language' => 'French',
            'locale' => 'fr'
        ]);
        DB::table('languages')->insert([
            'language' => 'Portuguese',
            'locale' => 'pt'
        ]);

    }

}
