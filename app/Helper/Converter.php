<?php


namespace App\Helper;

use App\Models\Converted;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;

class Converter
{

    private  $ffmpeg;
    public function __construct()
    {
        $this->ffmpeg = FFMpeg::create();
    }

    public function convertMp4ToMp3FromUrl(string $url) : array
    {
        // check if already converted
        $data = $this->getDataByUrl($url);
        if(!empty($data)){
            return $data;
        }

        $uniq = uniqid();
        $path = storage_path('converted/'.$uniq.'.mp3');
        try {
            $video = $this->ffmpeg->open($url);
            $audio_format = new Mp3();
            $video->save($audio_format, $path);
        } catch (\Exception $e) {
            dd($e);
        }

        $converted = new Converted();
        $converted->url = $url;
        $converted->path = $path;
        $converted->uniq_id = $uniq;
        $converted->save();

        return ['id' => $uniq, 'path' => $path];
    }

    public function getDataByUrl(string $url) : array
    {
        $data = [];

        $record = Converted::byUrl($url)->first();

        if($record){
            $data = ['id' => $record->uniq_id, 'path' => $record->path];
        }

        return $data;
    }
}
