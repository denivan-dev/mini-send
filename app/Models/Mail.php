<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Mail extends Model
{
    protected $guarded = [];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function setFilesAttribute(array $filesData)
    {
        $files = [];
        foreach ($filesData as $datum){
            $file_content = base64_decode($datum['content']);
            $file_name = 'public/attachments/' . sha1($datum['content']);
            Storage::disk('local')->put($file_name, $file_content);

            $files[] = new File([
                'path'        => $file_name,
                'client_name' => $datum['filename']
            ]);
        }

        if(count($files) > 0)
            $this->files()->saveMany($files);
    }

    public function setStatusAttribute(string $status)
    {
        $activity = new Activity(['status' => $status]);
        $this->activities()->save($activity);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
