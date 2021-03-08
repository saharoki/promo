<?php


namespace App\Helper;

// composer require php-ffmpeg/php-ffmpeg
class Converter
{
    public function convertMp4ToMp3FromUrl(string $url) : array
    {
        // check if already converted
        $data = $this->getDataByUrl($url);
        if(!empty($data)){
            return $data;
        }

        $uniq = uniqid();
        $path = storage_path('converted/'.$uniq.'.mp3');
        $video = $ffmpeg->open($url);
        $audio_format = new FFMpeg\Format\Audio\Mp3();
        $video->save($audio_format, $path);

        return ['id' => $uniq, 'path' => $path];
    }

    public function getDataByUrl(string $url) : array
    {

    }
}
