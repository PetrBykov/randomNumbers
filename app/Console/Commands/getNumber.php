<?php

namespace App\Console\Commands;

use App\Models\randNumbs;
use Illuminate\Console\Command;
use Exception;

class getNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'number:get {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets number by id';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $id = $this->argument('id');
            $numberFromDB = randNumbs::where('id', $id)->take(1)->get();
            if (count($numberFromDB)) {
                $number = $numberFromDB[0]['number'];
                $this->info($number);
            } else {
                $this->info('Not found');
            }
        } catch (Exception $e) {
            $this->info("Database error");
        }
    }
}
