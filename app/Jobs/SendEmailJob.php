<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\TestMail;
use Mail;
class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 



    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $sendMail;
    public function __construct($sendMail)
    {
        $this->sendMail = $sendMail;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new TestMail();
        Mail::to($this->sendMail)->send ($email);
    }
}