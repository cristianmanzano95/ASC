<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        //Se verifica que haya encabezado con el token de autorización.
        if($request->header('Authorization')){

            //Se busca el token en la base de datos
            $token = DB::connection('oracleCRIE')->select("SELECT * FROM Token WHERE Token = '".$request->header('Authorization')."' AND expiracion > CURRENT_TIMESTAMP AND Rol = '1000'");

            //Si existe el token
            if(count($token) > 0){
                // $token = $token[0];
                // error_log(base64_decode($request->header('Authorization'))[0] . "'");
                //Se busca el usuario en la base de datos para enviar la información a los controladores.
                // $UTP = DB::connection('oracleUTP')->select("SELECT * FROM ANDOVER.VI_CARNETUTP_ADMINITRATIVO WHERE token = '" . explode('.',base64_decode($request->header('Authorization')))[0] . "'");
                // $request->merge(['User' => $UTP]);
                return $next($request);
            }else{
                return response()->json([
                    'title' => 'Token invalido',
                    'detailed' => 'Token invalido'
                ], 401);
            }
        }else{
            return response()->json([
                'title' => 'Sin Autorización',
                'detailed' => 'Sin Autorización'
            ], 401);
        }
    }
}
