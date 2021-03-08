<?php


namespace App\Http\Controllers;


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
        $uniq = uniqid();

        event(new Convert($moviePath, $uniq));
        return response()->json(['id' => $uniq, 'mp3' => 'http://localhost:8000/api/mp3/'.$uniq]);
    }

    public function getMp3(Request $request, string $id)
    {
        if(trim($id) == '') {
            abort(400, 'Required parameter missing');
        }
    }
}
