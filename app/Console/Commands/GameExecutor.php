<?php

namespace App\Console\Commands;

use App\Events\NumberWinner;
use App\Events\NumberGenerate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GameExecutor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts executing the game';

    private $time = 15;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        while (true) {
            broadcast(new NumberGenerate($this->time));
            $this->time--;
            sleep(1);

            if ($this->time === 0) {

                broadcast(new NumberGenerate($this->time));

                broadcast(new NumberWinner(mt_rand(1, 12)));
                $this->time = 'Waiting to start';
                sleep(5);
                $this->time = 15;
            }
        }
    }
}
