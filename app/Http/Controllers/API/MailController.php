<?php

namespace App\Http\Controllers\API;

use App\Events\EmailPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostMailRequest;
use App\Http\Responses\MailPostedResponse;
use App\Models\Mail;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Arr;

class MailController extends Controller
{

    public function index()
    {
        $mails = app(Pipeline::class)
            ->send(Mail::query())
            ->through([
                \App\QueryFilters\Recipient::class
            ])
            ->thenReturn()
            ->with('files', 'activities')
            ->orderBy('id', 'desc')
            ->get();


        return $mails;
    }


    public function store(PostMailRequest $request)
    {
        $data = $request->prepared();
        $mail = Mail::create(
            Arr::except($data, ['files'])
        );

        $mail->status = 'posted';
        $mail->files  = $data['files'];

        event(new EmailPosted($mail));

        return new MailPostedResponse();
    }

    public function show($id)
    {
        return Mail::where('id', $id)->with('files', 'activities')->first();
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
