<?php

namespace App\Listeners;

use App\Events\EmailPosted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{

    public function __construct()
    {
        //
    }

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
            Log::info(__METHOD__, $mail->files->toArray());
            foreach ($mail->files as $attachment){
                $path = str_replace(
                    '/storage/attachments/',
                    storage_path('app/public/attachments/'),
                    $attachment['path']
                );

                if(File::exists($path))
                    $message->attach($path, [
                        'as' => $attachment['client_name'],
                    ]);
            }
        });
        $mail->status = 'sent';
    }
}
