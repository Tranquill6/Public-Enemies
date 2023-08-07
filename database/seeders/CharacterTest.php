<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Character;

class CharacterTest extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newChar = new Character;
        $newChar->name = 'Testy';
        $newChar->user_id = 3;
        $newChar->save();

    }
}
