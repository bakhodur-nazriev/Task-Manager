<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send task notifications to users';

    public function __constructor()
    {
        parent::__contruct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $tasks = Task::whereRaw('JSON_CONTAINS(days_of_week, \'["' . $now->dayOfWeek . '"]\')')
            ->where('job_time', $now->format('H:i:s'))
            ->get();

        foreach ($tasks as $task) {
            Mail::raw($task->text, function ($message) use ($task) {
                $message->to($task->email)
                    ->subject($task->title);
            });
        }
    }
}
