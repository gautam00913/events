<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
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
        $tickets= collect();
        $names = ['VIP', 'GOLD', 'Gratuit', 'Normal', "PASS"];
        for($i=0; $i<4; $i++)
        {
            $ticket = \App\Models\Ticket::firstOrCreate([
                'name' => $names[rand(0,4)]
            ]);
            $tickets->push($ticket);
        }
        $roles = Role::all()->pluck('id')->all();

        if(!$roles){
            $roles = [];
            $role = Role::create([
                'name' => 'evenementiel'
            ]);
            $roles[] =$role->id;
            Role::create([
                'name' => 'admin'
            ]);
            $role = Role::create([
                'name' => 'user'
            ]);
            $roles[] =$role->id;
        }

         \App\Models\User::factory(10)->create([
            'role_id' => $roles[rand(0,1)]
         ])->each(function($user) use($tags, $tickets){
            \App\Models\Event::factory(rand(1,5))->create([
                'user_id' => $user->id,
            ])->each(function($event) use($tags, $tickets){
                $event->tags()->attach($tags->random(3));
                $tickets->random(2)->each(function($ticket) use($event){
                    $place = rand(10, 100);
                    $ticket->events()->attach($event->id,[
                        'price' => rand(0, 20000),
                        'total_place' => $place,
                        'remaining_place' => $place
                    ]);
                });
            });
         });

        
    }
}
