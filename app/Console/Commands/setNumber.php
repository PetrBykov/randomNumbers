<?php

namespace App\Console\Commands;

use App\Models\randNumbs;
use Illuminate\Console\Command;
use Exception;

class setNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'number:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates new random number';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $newId = null;
            $number = new randNumbs;
            $number->number = rand(0, 100000);
            $number->save();
            $newId = $number->id;
            $this->info("New number's id: " . $newId);
        } catch (Exception $e) {
            $this->info("Database error");
        }
    }
}
