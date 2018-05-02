<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Parsers\SyslogParser;
use App\LogChart;

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

        $parser = new SyslogParser();
        $logs = $parser->parse($file);


        $charts=[];
        $logCharts = new LogChart();
        $charts["prog"] = $logCharts->getChart($logs["prog"]);
        $charts["day"] = $logCharts->getChart($logs["day"]);
        $charts["hour"] = $logCharts->getChart($logs["hour"]);
        $charts["user"] = $logCharts->getChart($logs["user"]);


        Mail::send('emails.summary', [
            'logs' => $logs,
            'chart' => $charts
        ], function ($m) {
            $m->from('news@loxnews.com', 'Loxnews');

            $m->to('svilborg@gmail.com', "Svilen")->subject("Logs Information");
        });
    }
}
