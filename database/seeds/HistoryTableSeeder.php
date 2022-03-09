<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\History;
use App\Models\User;
use App\Models\Request;
use Exception;
use Illuminate\Support\Str;
use App\Models\HistoryDetail;
use App\Enums\HistoryTypeEnum;

class HistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::beginTransaction();
        try {
            History::truncate();
            HistoryDetail::truncate();
            $requests = Request::all();
            $fieldValues = ['Name', 'Content'];
            $categoryValues = ['Team 1', 'Team 3', 'Team 2', 'Team 4'];
            $statusValues = ['In Progress', 'Closed'];
            foreach ($requests as $request) {
                History::create([
                    'request_id' => $request->id,
                    'user_id' => $request-> author_id,
                    'content' => 'create',
                    'type' => HistoryTypeEnum::HISTORY_TYPE_CREATE,
                ]);
                History::create([
                    'request_id' => $request->id,
                    'user_id' => $request-> author_id,
                    'content' => 'Ý tưởng tốt',
                    'type' => HistoryTypeEnum::HISTORY_TYPE_COMMENT,
                ]);
                $history = History::create([
                    'request_id' => $request->id,
                    'user_id' => $request-> author_id,
                    'content' => 'update',
                    'type' => HistoryTypeEnum::HISTORY_TYPE_UPDATE,
                ]);
                HistoryDetail::create([
                    'history_id' => $history->id,
                    'change_field' => $fieldValues[rand(0,1)],
                    'old_value' => '[Team 1]Create Request Detail UI',
                    'new_value' => '[Team 1] [FE] Create Request Detail UI',
                ]);
                HistoryDetail::create([
                    'history_id' => $history->id,
                    'change_field' => 'Status',
                    'old_value' => 'Open',
                    'new_value' => $statusValues[rand(0,1)],
                ]);
                HistoryDetail::create([
                    'history_id' => $history->id,
                    'change_field' => 'Category',
                    'old_value' => 'Team 0',
                    'new_value' => $categoryValues[rand(0,3)],
                ]);
            }
            DB::commit();
            echo "Done";
        } catch (Exception $e) {
                DB::rollBack();
                echo $e->getMessage();
        }
    }
}
