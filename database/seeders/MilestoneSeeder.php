<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Traits\SeederOperations;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MilestoneSeeder extends Seeder
{
    use SeederOperations;

    public function run(): void
    {
        $this->seedTableFromCsv('ss_milestones', base_path("database/dummyData/milestone.csv"));
        $this->seedTableFromCsv('ss_milestone_categories', base_path("database/dummyData/milestone_categories.csv"));
        $this->seedTableFromCsv('ss_milestone_category_tasks', base_path("database/dummyData/milestone_tasks.csv"));
    }

    private function seedTableFromCsv(string $table, string $csvPath, string $delimiter = ','): void
    {
        $records = $this->importCsv($csvPath);
        if (!is_array($records)) {
            throw new \RuntimeException("CSV file not found or unreadable: {$csvPath}");
        }
        foreach ($records as $record) {
            try {
                DB::table($table)->insert($record);
            } catch (Exception $e) {
                Log::error("Failed to insert", [
                    'error'  => $e->getMessage(),
                ]);
            }
        }
    }
}
