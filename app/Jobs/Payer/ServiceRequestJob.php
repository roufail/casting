<?php

namespace App\Jobs\Payer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\Payer\ServiceRequest;
class ServiceRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $client,$user,$service;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($client,$user,$service)
    {
        $this->client  = $client;
        $this->user    = $user;
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->user->notify((new ServiceRequest($this->client,$this->service))->locale(app()->getLocale()));
    }
}
