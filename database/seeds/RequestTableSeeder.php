<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Request;

class RequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Request::factory()->count(10)->create();
    }
}
