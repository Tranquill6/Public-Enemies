<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Rank;
use App\Models\Crime;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $crimes = Crime::all();
        $ranks = Rank::all();

        foreach($ranks as $rank) {
            foreach($crimes as $crime) {
                DB::insert('INSERT INTO crimes_ranks (crime_id, rank_id, allowed) VALUES (?, ?, ?)', [$crime['id'], $rank['id'], 0]);
            }
        }
    }
}
