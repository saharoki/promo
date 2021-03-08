<?php


namespace App\Helper;

use App\Models\Converted;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;

class Converter
{

    /**
     * @var FFMpeg
     */
    private  $ffmpeg;

    public function __construct()
    {
        $this->ffmpeg = FFMpeg::create([
            'timeout' => 3600
        ]);
    }

    /**
     * @param string $url
     * @return array
     */
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
            //$video = $this->ffmpeg->open($url);
            $video = $this->ffmpeg->open($url);
            $audioFormat = new Mp3();
            $video->save($audioFormat, $path);
        } catch (\Exception $e) {
            abort(500);
        }

        $converted = new Converted();
        $converted->url = $url;
        $converted->path = $path;
        $converted->uniq_id = $uniq;
        $converted->save();

        return ['id' => $uniq, 'path' => $path];
    }

    /**
     * @param string $url
     * @return array
     */
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
