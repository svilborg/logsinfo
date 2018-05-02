<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\SyslogParserCliPresentation;
use App\SyslogParser;

class Send extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send';

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
        $parser = new SyslogParser();
        $logs = $parser->parse();

        Mail::send('emails.summary', [
            'logs' => $logs
        ], function ($m) {
            $m->from('news@loxnews.com', 'Loxnews');

            $m->to('svilborg@gmail.com', "Svilen")->subject("Logs Information");
        });
    }
}
