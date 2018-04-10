<?php

namespace App\Console\Commands;

use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Console\Command;

class SendAMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-message {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message';

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
        $botman = resolve('botman');

        $id = $this->argument('id');

        $botman->say("I'm watching you...", $id, TelegramDriver::class);
    }
}
