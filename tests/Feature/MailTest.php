<?php

namespace Tests\Feature;

use App\Models\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Http\Requests\PostMailRequest;

class MailTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    /** @test */
    public function large_files_can_not_be_attached(){
        $bytes = str_repeat('#', PostMailRequest::MAX_FILE_SIZE_MB * 1024 * 1024);
        $base64_str = base64_encode($bytes);

        $attachments = [
            'attachments' => [
                [
                    'filename' => 'test.png',
                    'content' => $base64_str,
                ],
            ]
        ];

        $response = $this->postEmail($attachments);
        $response->assertStatus(422);
    }

    /** @test */
    public function recipient_email_is_required(){
        $response = $this->postEmail(['to' => null]);
        $response->assertStatus(422);
    }

    /** @test */
    public function content_is_required(){
        $response = $this->postEmail(['content' => null]);

        $response->assertStatus(422);
    }

    /** @test */
    public function send_email_request_can_be_posted()
    {
        $this->withoutExceptionHandling();
        Storage::fake('local');

        $base64_file_content = base64_encode(
            file_get_contents(__DIR__ . '/../test.png')
        );
        $base64_file_name = sha1($base64_file_content);
        Log::info(__METHOD__, [$base64_file_name]);

        $attachments = [
            'attachments' => [
                [
                    'filename' => 'test.png',
                    'content' => $base64_file_content,
                ],
            ]
        ];

        $data = $this->data();
        $response = $this->json(
            'POST',
            '/api/email',
            array_merge($data, $attachments)
        );

        $response->assertStatus(202);
        Storage::disk('local')->assertExists('attachments/' . $base64_file_name);

        $this->assertDatabaseHas('mails', [
            'recipient' => $data['to']['email'],
        ]);

        $this->assertDatabaseHas('activities', [
            'status' => 'posted',
        ]);

        $this->assertDatabaseHas('files', [
            'client_name' => 'test.png',
        ]);

        $mail = Mail::first();
        $this->assertCount(1, $mail->files);
    }

    private function data(){
        return [
            'from' => [
                'email' => $this->faker->unique()->email,
                'name'  => $this->faker->unique()->name,
            ],

            'to' => [
                'email' => $this->faker->unique()->email,
            ],

            'subject' => $this->faker->title,
            'content' => $this->faker->randomHtml(2,3),
        ];
    }

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    private function postEmail($data): \Illuminate\Testing\TestResponse
    {
        return $this->json(
            'POST',
            '/api/email',
            array_merge($this->data(), $data)
        );
    }
}
