<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 04.02.21
 * Time: 14:57
 */

namespace App\Http\Responses;


use Illuminate\Contracts\Support\Responsable;

class MailPostedResponse implements Responsable
{

    public function prepareData(){
        return [
          'message' => 'Queued'
        ];
    }

    public function toResponse($request)
    {
        return response()->json($this->prepareData(), 202);
    }
}
