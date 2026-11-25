<?php

namespace App\Jobs;

use App\Models\Contact;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendContactNotification implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public function __construct(public Contact $contact) {}

    public function handle(): void
    {
        sleep(3);

        Log::info("Pesan baru dari {$this->contact->name}", [
            'contact_id' => $this->contact->id,
        ]);
    }

    public function failed(Throwable $e): void
    {
        Log::error('Job SendContactNotification gagal: ' . $e->getMessage(), [
            'contact_id' => $this->contact->id,
        ]);
    }
}