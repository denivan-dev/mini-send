<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostMailRequest extends FormRequest
{
    const MAX_FILE_SIZE_MB = 5;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $max_file_size = self::MAX_FILE_SIZE_MB * 1024 * 1024;
        $max_base64_len = $max_file_size * 4 / 3;
        $max_base64_len = floor($max_base64_len);

        return [
            'to.email'   => 'required|email|max:255',
            'from.email' => 'required_with:from|email|max:255',
            'from.name'  => 'sometimes|max:255',
            'subject'    => 'required|max:255',
            'content'    => 'required',
            'type'       => 'in:text,html',
            'attachments.*.filename' => 'required_with:attachments|max:255',
            'attachments.*.content'  => 'required_with:attachments|max:' . $max_base64_len,
        ];
    }

    public function messages()
    {
        return [
            'attachments.*.content' =>
                'file size should not exceed ' . self::MAX_FILE_SIZE_MB . ' MB',
        ];
    }

    public function prepared(){
        $data = $this->validated();

        $attributes['sender_email'] = $data['from']['email'] ?? config('mail.from.address');
        $attributes['sender_name']  = $data['from']['name'] ?? config('mail.from.name');
        $attributes['recipient']    = $data['to']['email'];
        $attributes['subject']      = $data['subject'];
        $attributes['content']      = $this->sanitizeContent($data['content']);
        $attributes['type']         = $data['type'] ?? 'html';

        $attributes['files']        = $data['attachments'] ?? [];

        return $attributes;
    }

    private function sanitizeContent($content)
    {
        return preg_replace('~<script(.*?)>(.*?)</script>~is', '', $content);
    }
}
