<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Parsers\SyslogParser;
use App\LogChart;
use App\Parsers\ApacheLogParser;
use App\Parsers\ParserStrategy;

class Send extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send
             {--f=0 : Syslog file}
             ';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $type = "apachelog";

        $parser = ParserStrategy::getParser($type);
        $logs = $parser->parse($file);

        $charts=[];
        $logCharts = new LogChart();

        if($type == "apachelog") {
            $fields = ["day", "hour", "method", "ip", "code"];
        }
        else {
            $fields = ["day", "hour", "prog", "user"];
        }

        foreach ($fields as $field) {
            $charts[$field] = $logCharts->getChart($logs[$field]);
        }
        Mail::send('emails.summary_'.$type, [
            'logs' => $logs,
            'chart' => $charts
        ], function ($m) {
            $m->from('news@loxnews.com', 'Loxnews');

            $m->to('svilborg@gmail.com', "Svilen")->subject("Logs Information");
        });
    }
}
