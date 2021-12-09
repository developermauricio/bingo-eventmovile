<?php

namespace App\Http\Controllers;

use App\Models\TableBingo;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getPathTableBingo(){
        $files = Storage::disk('public')->allFiles('tables');
        foreach ($files as $file){
         $pathFirst = TableBingo::where('path', $file)->first();
         if (!$pathFirst){
             TableBingo::create([
                'path' => $file
             ]);
         }
        }

       return dd($files);
    }

    public function downloadTableBingo(Request $request){
        $userEmail = $request->get('email');
        $tableUser = TableBingo::where('email', $userEmail)->first();
        if ($tableUser){
            return back()->with('error', 'Este usuario ya ha descargado el archivo');
        }

        $tableBingo = TableBingo::inRandomOrder()->where('download', false)->first();
        if ($tableBingo) {
            $tableBingo->email = $userEmail;
            $tableBingo->download = 1;
            $tableBingo->save();
            return Storage::disk('public')->download($tableBingo->path);
        }else{
            return back()->with('error', 'Ya no hay tablas de bingo disponibles');
        }
    }
}
