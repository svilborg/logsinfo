<?php
namespace App\Console\Commands;

use App\Parsers\ParserStrategy;
use Illuminate\Console\Command;

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

        $this->output->note("Log Info");

        if($all || $this->option("d")) {
            $this->tableFromLogs($logs, "day");
        }

        if($all || $this->option("h")) {
            $this->tableFromLogs($logs, "hour");
        }

        if(($type == "apachelog") && ($all || $this->option("m"))) {
            $this->tableFromLogs($logs, "method");
        }

        if(true) {
            $this->tableFromLogs($logs, "data");
        }
    }

    private function tableFromLogs($logs, $key) {
        $this->info(ucfirst($key));
        $this->table($this->getTableRows($logs[$key]), $logs[$key]);
        $this->info("");
    }

    private function getTableRows($array) {
        $records = array_pop($array);

        if($records) {
            return array_map('ucfirst', array_keys($records));
        }

        return [];
    }
}
