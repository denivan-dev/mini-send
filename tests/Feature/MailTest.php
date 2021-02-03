<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MailTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    /** @test */
    public function send_email_request_can_be_posted()
    {
        Storage::fake('attachments');
        $base64_file_content = base64_encode(
            file_get_contents(__DIR__ . '/../test.png')
        );

        $base64_file_name = sha1($base64_file_content);

        $response = $this->json('POST', '/api/email', [
            'from' => [
                'email' => $this->faker->unique()->email,
                'name'  => $this->faker->unique()->name,
            ],

            'to' => [
                'email' => $this->faker->unique()->email,
                'name'  => $this->faker->unique()->name,
            ],

            'subject' => $this->faker->title,
            'content' => $this->faker->randomHtml(2,3),

            'attachments' => [
                'contents' => [
                    $base64_file_content,
                ],

                'filenames' => [
                    'https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Test-Logo.svg/783px-Test-Logo.svg.png',
                ]
            ]
        ]);

        $response->assertStatus(201);
        Storage::disk('attachments')->assertExists($base64_file_name);

        $this->assertDatabaseHas('files', [
            'name' => $base64_file_name,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'sally@example.com',
        ]);

        $mail = Mail::first();
        $this->assertCount(2, $mail->files());
    }
}
