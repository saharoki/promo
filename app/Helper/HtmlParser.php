<?php

namespace App\Helper;

use GuzzleHttp\Client;
use PHPHtmlParser\Dom;

class HtmlParser
{
    /**
     * @var Dom
     */
    private $dom;

    public function __construct()
    {
        $this->dom = new Dom();
    }

    public function firstMovieFromCategory(string $category)
    {
        $url = config('param.promoTemplateBaseUrl').$category;
        try {
            $client = new Client(['verify' => false ]);
            $this->dom->loadFromUrl($url, null, $client);
        } catch (\Exception $e) {
            return false;
        }

        $content = $this->dom->find('.video-item__thumbnail')[0];
        if(!$content){
            return false;
        }
        $pathArr = explode('--', $content->getAttribute('data-src'));
        if(empty($pathArr)){
            return false;
        }
        $path = $pathArr[0].'/preview.mp4';
        $versionArr = explode('?', $pathArr[1]);
        if(array_key_exists(1, $versionArr)){
            $path.='?'.$versionArr[1];
        }

        $succees = true;
        try{
            $response = $client->head($path);
        } catch (\Exception $e) {
            $succees = false;
        }

        // file not found in first link
        if(!$succees){
            $path = str_replace('/collections/', '/promoVideos/', $path);
            try{
                $response = $client->head($path);
            } catch (\Exception $e) {
                return false;
            }
        }

        return $path;
    }
}
