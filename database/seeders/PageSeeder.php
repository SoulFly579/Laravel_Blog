<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = ['Hakkımızda','Kariyer','Vizyon','Misyon'];
        $count=0;
        foreach ($pages as $page){
            $count++;
            DB::table('pages')->insert([
                'title'=>$page,
                'slug'=>Str::slug($page),
                'image'=>'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80',
                'content'=>'But I must explain to you how all this mistaken idea of denouncing pleasure and
                praising pain was born and I will give you a complete account of the system, and expound the
                actual teachings of the great explorer of the truth, the master-builder of human happiness.
                No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those
                who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.
                 Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it
                 is pain, but because occasionally circumstances occur in which toil and pain can procure him
                 some great pleasure. To take a trivial example, which of us ever undertakes laborious physical
                 exercise, except to obtain some advantage from it? But who has any right to find fault with a man
                 who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that
                 produces no resultant pleasure?',
                'order'=>$count,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }

    }
}
