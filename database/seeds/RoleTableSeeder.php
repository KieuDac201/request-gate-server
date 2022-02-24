<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Facade\FlareClient\Truncation\TruncationStrategy;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            ['name' => 'Admin'],
            ['name' => 'Quản lý bộ phận'],
            ['name' => 'Cán bộ nhân viên'],
        ]);
    }
}
