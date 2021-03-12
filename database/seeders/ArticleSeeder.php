<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $title = $faker->sentence(6);
        for($i=0; $i<4; $i++){
            DB::table('articles')->insert([
                'category_id' => rand(1,7),
                'title' => $title,
                'image' => $faker->imageUrl(150, 150, 'cats', true, 'Faker'),
                'content'=>$faker->paragraph(6),
                'slug'=>Str::slug($title),
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
    }
}
