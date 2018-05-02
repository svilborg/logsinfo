<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Parsers\SyslogParserCliPresentation;
use App\Parsers\ApacheLogParser;

class ApacheLog extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apachelog
             {--f=0 : Syslog file}
             {--a : All Info}
             {--h : Hourly}
             {--d : Daily}
             {--m : Per Method}
            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parses syslog';

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
        $file = $this->option("f");
        $all = $this->option("a");


        $this->output->note($file);

        $parser = new ApacheLogParser();
        $logs = $parser->parse($file);

        if($all || $this->option("d")) {
            $this->table(["Day", "Logs"], $logs["day"]);
        }

        if($all || $this->option("h")) {
            $this->table(["Hour", "Logs"], $logs["hour"]);
        }

        if($all || $this->option("m")) {
            $this->table(["Method", "Logs"], $logs["method"]);
        }

//         if($all || $this->option("u")) {
//             $this->table(["Program", "Logs"], $logs["prog"]);
//         }

        if(true) {
            $this->table(["User", "Program", "Time"], $logs["data"]);
        }
    }
}
