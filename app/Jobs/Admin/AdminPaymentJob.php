<?php

namespace App\Jobs\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Admin;

use App\Notifications\Admin\AdminPaymentNotification;
class AdminPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $userService;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userService)
    {
        $this->userService = $userService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $admins = Admin::all();
        \Notification::send($admins, new AdminPaymentNotification($this->userService));
    }
}
