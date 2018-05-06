<?php
namespace App\Console\Commands;

use App\Parsers\ApacheLogParser;
use Illuminate\Console\Command;
use App\Parsers\ParserStrategy;

class Show extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logsinfo:show
             {--f=0 : Log file}
             {--t=syslog : file type}
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
    public function handle(ParserStrategy $parserStratagy)
    {
        $file = $this->option("f");
        $type = $this->option("t");
        $all = $this->option("a");

        $parser = $parserStratagy->getParser($type, ["trim" => 81, "count" => 10]);

        $logs = $parser->parse($file);

        $this->output->note($file);

        if($all || $this->option("d")) {
            $this->table(["Day", "Logs"], $logs["day"]);
        }

        if($all || $this->option("h")) {
            $this->table(["Hour", "Logs"], $logs["hour"]);
        }

        if($all || $this->option("m")) {
            $this->table(["Method", "Logs"], $logs["method"]);
        }

        if(true) {
            $this->table(["Ip", "Time", "Method", "Path", "", "Code"], $logs["data"]);
        }
    }
}
