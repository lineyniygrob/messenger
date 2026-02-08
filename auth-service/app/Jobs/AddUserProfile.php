<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddUserProfile implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private $id,
        private $email,
        private $name = null
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Http::timeout(5)
            ->connectTimeout(5)
            ->withHeaders([
                'X-Id-User' => $this->id,
                'X-Email-User' => $this->email,
                'X-Name-User' => $this->name
            ])
            ->post("http://user-web/api/profile/add");
    }
}
