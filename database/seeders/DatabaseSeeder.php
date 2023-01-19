<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tags= \App\Models\Tag::factory(8)->create();
        $tickets= \App\Models\Ticket::factory(3)->create();
         \App\Models\User::factory(10)->create()->each(function($user) use($tags, $tickets){
            \App\Models\Event::factory(rand(1,5))->create([
                'user_id' => $user->id
            ])->each(function($event) use($tags, $tickets){
                $event->tags()->attach($tags->random(3));
                $place = rand(10, 100);
                $event->tickets()->attach($tickets->random(2), [
                    'price' => rand(0, 20000),
                    'total_place' => $place,
                    'remaining_place' => $place
                ]);
            });
         });

        
    }
}
