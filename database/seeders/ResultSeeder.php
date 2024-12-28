<?php

namespace Database\Seeders;

use App\Models\Result;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResultSeeder extends Seeder
{
    private $records = 0;
    private $failures = 0;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            Result::factory()
                ->count(1)
                ->create();
            $this->records++;
        } catch(Exception $e) {
            $this->failures++;
        }

        if ($this->records < 5000) {
            $this->run();
        } else {
            print("Hibas probalkozasok: " . $this->failures . "\n");
        }


    }
}
