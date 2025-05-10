<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minishlink\WebPush\VAPID;


class GenerateVapidKeys extends Command
{
    protected $signature = 'webpush:vapid';
    protected $description = 'Generate VAPID keys for web push notifications';

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
        $vapidKeys = VAPID::createVapidKeys();
        
        $this->info('VAPID keys generated successfully:');
        $this->line('Public Key: ' . $vapidKeys['publicKey']);
        $this->line('Private Key: ' . $vapidKeys['privateKey']);
        
        $this->info("\nAdd these to your .env file:");
        $this->line('VAPID_PUBLIC_KEY=' . $vapidKeys['publicKey']);
        $this->line('VAPID_PRIVATE_KEY=' . $vapidKeys['privateKey']);
        $this->line('VAPID_SUBJECT=mailto:your@email.com');
    }
}
