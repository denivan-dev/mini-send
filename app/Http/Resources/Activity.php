<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Activity extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'email_id'         => $this->mail->id,
            'event'      => $this->status,
            'recipient'  => $this->mail->recipient,
            'sender'  => $this->mail->sender_email,
            'subject'    => $this->mail->subject,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
