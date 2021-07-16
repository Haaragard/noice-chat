<?php

namespace Database\Seeders;

use App\Models\ChatRoom;
use Illuminate\Database\Seeder;

class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatRoom::create([ 'name' => 'General' ]);
        ChatRoom::create([ 'name' => 'Tech Talk' ]);
    }
}
