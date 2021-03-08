<?php


namespace App\Http\Controllers;


use App\Facade\Converter;
use App\Facade\HtmlParser;
use App\Models\Converted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

        //check if file exist
        $record = Converted::byUniqId($id)->first();
        if(!$record || !file_exists($record->path)){
            abort(404, 'file not found');
        }

       header('Content-Type: application/octet-stream');
       header("Content-Disposition: attachment; filename=" .basename($record->path));
       header('Content-Transfer-Encoding: Binary');
       readfile($record->path);
    }
}
