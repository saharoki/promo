<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Converted extends Model
{
    protected $table = 'converted';
    public $timestamps = true;

    public function scopeByUrl($query, $url){
        $query->where('url', $url);
    }
}
