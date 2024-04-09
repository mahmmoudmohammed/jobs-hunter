<?php

namespace App\Jobs;

use App\Http\Controllers\Api\Modules\Users\Models\User;
use App\Mail\VerificationOTP;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailVerificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $otpCode;

    public $priority = 'high';

    public $tries = 3;


    public function __construct(User $user, $otpCode)
    {
        $this->user = $user;
        $this->otpCode = $otpCode;
    }

    public function handle()
    {
        Mail::to($this->user->email)->send(new VerificationOTP($this->user, $this->otpCode));
    }
}
