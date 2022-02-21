<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert(array(
            array(
                'name' => "HB1",
                'status' => '1',
            ),
            array(
                'name' => "HCNS",
                'status' => '1',
            ),
            array(
                'name' => "Kế toán",
                'status' => '1',
                ),
            array(
                'name' => "Tuyển dụng",
                'status' => '1',
            ),
            array(
                'name' => "Admin",
                'status' => '1',
            ),
        ));
    }
}
