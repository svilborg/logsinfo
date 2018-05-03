<?php
namespace App\Console\Commands;

use App\LogChart;
use App\Parsers\ParserStrategy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class Send extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send
             {--f=0 : log file}
             {--t=syslog : file type}
             {--m=test.gmail : email}
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
    public function handle(LogChart $logCharts, ParserStrategy $parserStratagy)
    {
        $file = $this->option("f");
        $type = $this->option("t");
        $email = $this->option("m");

        $parser = $parserStratagy->getParser($type);

        $logs = $parser->parse($file);
        $fields = $parser->getFields();

        $charts=[];

        foreach ($fields as $field) {
            $charts[$field] = $logCharts->getChart($logs[$field]);
        }

        Mail::send('emails.summary_'.$type, [
            'logs' => $logs,
            'chart' => $charts
        ], function ($m) use($email) {
            $m->from('news@loxnews.com', 'Loxnews');

            $m->to($email, "Subscriber")->subject("Logs Information");
        });
    }
}
