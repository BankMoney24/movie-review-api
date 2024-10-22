<?php

namespace App\Console\Commands;

use App\Mail\DailyMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send-daily-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send daily emails to all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        foreach($users as $user){
            Mail::to($user->email)->send(new DailyMail($user));
            usleep(1000000);
        }
        $this->info('daily emails sent successfully');
    }
}
