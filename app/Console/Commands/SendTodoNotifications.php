<?php

namespace App\Console\Commands;

use App\Models\Todo;
use App\Http\Controllers\NotificationController;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendTodoNotifications extends Command
{
    protected $signature = 'todos:send-notifications';
    protected $description = 'Send notifications for due todos';

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
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $todos = Todo::with('user')->get();

        foreach ($todos as $todo) {
            NotificationController::sendNotification(
                $todo->user,
                'Todo Due: ' . $todo->title,
                $todo->description ?: 'Your todo is due now!'
            );

            $todo->update(['notification_sent' => true]);
        }

        $this->info('Sent notifications for ' . $todos->count() . ' todos.');
    }
}
