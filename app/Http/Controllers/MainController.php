<?php


namespace App\Http\Controllers;


use App\Facade\Converter;
use App\Facade\HtmlParser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MainController extends Controller
{

    public function promo2mp3(Request $request)
    {
        try {
            $this->validate($request,
                [
                    'category' => 'required|string',
                ]);
        } catch(ValidationException $e){
            throw $e;
        }

        $category = $request->input('category');
        $moviePath = HtmlParser::firstMovieFromCategory($category);
        if(!$moviePath){
            abort(404, 'Movie not found');
        }

        $data = Converter::convertMp4ToMp3FromUrl($moviePath);
        return response()->json(['id' => $data['id'], 'mp3' => 'http://localhost:8000/api/mp3/'.$data['id']]);
    }

    public function getMp3(Request $request, string $id)
    {
        if(trim($id) == '') {
            abort(400, 'Required parameter missing');
        }
    }
}
