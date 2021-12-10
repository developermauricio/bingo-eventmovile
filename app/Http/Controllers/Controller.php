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
use Rap2hpoutre\FastExcel\FastExcel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function indexImportView()
    {
        return view('import-user');
    }

    /***  Metodo para guardar los usuarios desde un archivo excel   ***/
    public function setUserDB( Request $request ) {
        $data = $request->file('data');

        $user = ( new FastExcel )->import( $data, function($line) {
            $name = $line['Nombre'] ? $line['Nombre'] : 'New';
            $lastname = $line['Apellido'] ? $line['Apellido'] : 'User';
            $email = $line['email'] ? $line['email'] : 'exampe@gmail.com';

            if ( $this->validateDataUser( $email) ){
                return User::create([
                    'name' => $name + $lastname,
                    'email' => $email,
                ]);
            }
            
        });
        
        return response()->json('ok');        
    }

    public function validateDataUser( $email ) {        
        if (!$email) return false;

        $currentUser = User::whereEmail($email)->first();

        if ( $currentUser ) {
            return false;            
        } else {
            return true;
        }
    }

    /***  Metodo para guardar el path de las tablas de bingo  ***/
    public function getPathTableBingo(){
        $files = Storage::disk('public')->allFiles('tables');

        foreach ($files as $file){
            $pathFirst = TableBingo::where('path', $file)->first();

            if ( !$pathFirst ){
                TableBingo::create([
                    'path' => $file
                ]);
            }
        }

       return dd($files);
    }

    /*  Metodo para realizar la descarga de la tabla de bingo */
    public function downloadTableBingo(Request $request){
        $userEmail = $request->get('email');

        $currentUser = User::whereEmail($userEmail)->first();
        if ( !$currentUser ) {
            return back()->with('error', 'El usuario con este correo no se encuentra registrado, por favor verifique nuevamente el correo.');
        }

        $tableUser = TableBingo::where('email', $userEmail)->first();
        if ( $tableUser ){
            return back()->with('error', 'El usuario con este correo electrónico ya realizo la descarga del archivo');
        }

        $tableBingo = TableBingo::inRandomOrder()->where('download', false)->first();
        if ( $tableBingo ) {
            $tableBingo->email = $userEmail;
            $tableBingo->download = 1;
            $tableBingo->save();

            return Storage::disk('public')->download($tableBingo->path);
        }else{
            return back()->with('error', 'Ya no hay tablas de bingo disponibles');
        }
    }

}
