<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Question;

class softDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:softdelete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will soft delete question with empty value answer';

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
        $date = new \DateTime();
        $date->modify('-24 hours');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $question=Question::orderBy('created_at','asc')->where('created_at', '>',$formatted_date)->where('answer', null);
        $question->delete();

    }
}
