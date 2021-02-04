<?php

namespace App\Listeners;

use App\Events\EmailPosted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmailPosted  $event
     * @return void
     */
    public function handle(EmailPosted $event)
    {
        $mail = $event->mail;
        $mail->load('files');

        $content = [$mail->content];
        if($mail->type === 'html')
            array_push($content, 'text/html');

        Mail::send([], [], function ($message) use ($mail, $content){
            $message->to($mail->recipient)
                ->from($mail->sender_email, $mail->sender_name)
                ->subject($mail->subject)
                ->setBody(...$content);

            foreach ($mail->files as $attachment){
                $message->attach($attachment['content'], [
                    'as' => $attachment['name'],
                ]);
            }
        });
        $mail->status = 'sent';
    }
}
