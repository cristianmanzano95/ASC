<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datetime;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        // utp es para docentes y adminsitrativos pruebas es para estudiantes
        // $user = "uid=consultasweb,dc=utp"; //ruta completa del usuario en el directorio

        //Asigna la variables usadas para la conexión LDAP
        $usuario = $request->input('user');
        $password = $request->input('password');
        $servidor_ldap = 'ldap.utp.edu.co';
        $puerto_ldap = "778";

        //Configuración LDAP
        $ds = ldap_connect($servidor_ldap, $puerto_ldap);
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

        //Valida si hubo conexión con el servidor LDAP
        if ($ds) {
            //dc=utp es para administrativos y docentes, dc=pruebas es para estudiantes
            $user = "uid=" . $usuario . ",ou=usuarios,dc=utp";
            //Se valida el ingreso del usuario
            if (@ldap_bind($ds, $user, $password)) {
                //Se prepara el directorio de la búsqueda.
                $dn = "ou=usuarios,dc=utp";
                //Se configura el filtro con que se quiere realizar la busqueda.
                $filtro = "(|(uid=$usuario))";
                //Se configura el vector de las variables que queremos conocer su valor.
                $datos = array("idtercero");
                //Se realiza la busqueda en el servidor LDAP.
                $sr = @ldap_search($ds, $dn, $filtro, $datos);
                //Se almacena el redultado en la variable info
                $info = @ldap_get_entries($ds, $sr);

                $UTP = DB::connection('oracleUTP')->select(
                    "SELECT idtercero, nombres, apellidos, numerodocumento, cargo, tipocarnet, programadependencia from ANDOVER.VI_CARNETUTP_ADMINITRATIVO
                    WHERE idtercero = '" . $info[0]['idtercero'][0] . "'
                    UNION
                    SELECT idtercero, nombres, apellidos, numerodocumento, cargo, tipocarnet, programadependencia from ANDOVER.VI_CARNETUTP_DOCENTE
                    WHERE idtercero = '" . $info[0]['idtercero'][0] . "'");
                //Se consulta el idtercero con la base de datos de la utp para extraer más información del usuario (Además informacion actualizada, ya que lso datos de usuario en LDAP al parecer no se actualiza frecuentemente)
                //$UTP = DB::connection('oracleUTP')->select("SELECT * FROM registro.VI_RYC_ESTUDIANTESACTIVOS WHERE IDTERCERO = '" . $info[0]['idtercero'][0] . "'");
                if(count($UTP) == 0){
                    return response()->json([
                        'title' => 'Usuario Incorrecto', 'detailed' => 'El usuario no tiene acceso.'
                    ], 400);
                }
                //Se toma la fechahora actual y se le suma el tiempo de sesión (30 minutos)
                $DateAndTime = new Datetime('America/Bogota');
                $fecha = $DateAndTime->format('Y-m-d H:i:s');
                $expiracion = $DateAndTime->modify('+60 minutes')->format('Y-m-d H:i:s');

                // Se crea el token con el formato idtercero.fecha_expiracion.usuario y se guarda en la base de datos
                $token = base64_encode($info[0]['idtercero'][0] . "." . $expiracion .".".$usuario);
                DB::connection('oracleCRIE')->insert("
                    INSERT INTO Token (
                        idtercero,
                        token,
                        fecha,
                        expiracion,
                        rol
                    )VALUES(
                        '".$info[0]['idtercero'][0]."',
                        '".$token."',
                        TO_TIMESTAMP('".$fecha."', 'YYYY-MM-DD HH24:MI:SS'),
                        TO_TIMESTAMP('".$expiracion."', 'YYYY-MM-DD HH24:MI:SS'),
                        '0'
                    )
                ");

                return response()->json([
                    'token' =>  $token,
                    'user' => $UTP
                ], 200);
            } else {
                //ruta completa del usuario en el directorio prueba (estudiantes)
                $user = "uid=" . $usuario . ",ou=usuarios,dc=utp";
                if (@ldap_bind($ds, $user, $password)) {
                    return response()->json([
                        'title' => 'Usuario Incorrecto', 'detailed' => 'El usuario no tiene acceso porque no es docente o administrativo.'
                    ], 400);
                } else {
                    return response()->json([
                        'title' => 'Usuario/Contraseña Incorrecto', 'detailed' => 'Usuario y/o contraseña incorrectos.'
                    ], 400);
                }
            }
        } else {
            ldap_close($ds);
            return response()->json([
                'title' => 'Error LDAP', 'detailed' => 'No se pudo establecer conexión con el servidor LDAP.'
            ], 400);
        }
    }

    public function admin_login(Request $request)
    {
        // utp es para docentes y adminsitrativos pruebas es para estudiantes
        // $user = "uid=consultasweb,dc=utp"; //ruta completa del usuario en el directorio

        //Asigna la variables usadas para la conexión LDAP
        $usuario = $request->input('user');
        $password = $request->input('password');
        $servidor_ldap = 'ldap.utp.edu.co';
        $puerto_ldap = "778";

        //Configuración LDAP
        $ds = ldap_connect($servidor_ldap, $puerto_ldap);
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);

        //Valida si hubo conexión con el servidor LDAP
        if ($ds) {
            //dc=utp es para administrativos y docentes, dc=pruebas es para estudiantes
            $user = "uid=" . $usuario . ",ou=usuarios,dc=utp";
            //Se valida el ingreso del usuario
            if (@ldap_bind($ds, $user, $password)) {
                //Se prepara el directorio de la búsqueda.
                $dn = "ou=usuarios,dc=utp";
                //Se configura el filtro con que se quiere realizar la busqueda.
                $filtro = "(|(uid=$usuario))";
                //Se configura el vector de las variables que queremos conocer su valor.
                $datos = array("idtercero");
                //Se realiza la busqueda en el servidor LDAP.
                $sr = @ldap_search($ds, $dn, $filtro, $datos);
                //Se almacena el redultado en la variable info
                $info = @ldap_get_entries($ds, $sr);

               /*  $UTP = DB::connection('oracleUTP')->select(
                    "SELECT idtercero, nombres, apellidos, numerodocumento, cargo, tipocarnet as tipousuario, programadependencia as dependencia from ANDOVER.VI_CARNETUTP_ADMINITRATIVO
                    WHERE numerodocumento = '" . $info[0]['numerodocumento'][0] . "'
                    UNION
                    SELECT idtercero, nombres, apellidos, numerodocumento, cargo, tipocarnet, programadependencia from ANDOVER.VI_CARNETUTP_DOCENTE
                    WHERE numerodocumento = '" . $info[0]['numerodocumento'][0] . "'"); */
                //Se consulta el idtercero con la base de datos de la utp para extraer más información del usuario (Además informacion actualizada, ya que lso datos de usuario en LDAP al parecer no se actualiza frecuentemente)
                $UTP = DB::connection('oracleUTP')->select("SELECT * FROM ANDOVER.VI_CARNETUTP_ADMINITRATIVO WHERE IDTERCERO = '" . $info[0]['idtercero'][0] . "'");


                //Se consulta en la tabla de administradores
                $Admin = DB::connection('oracleCRIE')->select("SELECT * from Administrador WHERE IDTERCERO = '" . $info[0]['idtercero'][0] . "'");
                if(count($Admin) > 0){
                    //Se toma la fechahora actual y se le suma el tiempo de sesión (30 minutos)
                    $DateAndTime = new Datetime('America/Bogota');
                    $fecha = $DateAndTime->format('Y-m-d H:i:s');
                    $expiracion = $DateAndTime->modify('+60 minutes')->format('Y-m-d H:i:s');
                    // Se crea el token con el formato idtercero.fecha_expiracion.usuario y se guarda en la base de datos
                    $token = base64_encode($info[0]['idtercero'][0] . "." . $expiracion .".".$usuario);
                    error_log("token");
                    error_log($token);
                    DB::connection('oracleCRIE')->insert("
                        INSERT INTO Token (
                            idtercero,
                            token,
                            fecha,
                            expiracion,
                            rol
                        )VALUES(
                            '".$info[0]['idtercero'][0]."',
                            '".$token."',
                            TO_TIMESTAMP('".$fecha."', 'YYYY-MM-DD HH24:MI:SS'),
                            TO_TIMESTAMP('".$expiracion."', 'YYYY-MM-DD HH24:MI:SS'),
                            '1000'
                        )
                    ");

                    return response()->json([
                        'token' =>  $token
                    ], 200);
                }else{
                    return response()->json([
                        'title' => 'No es administrador',
                        'detailed' => 'El usuario no es administrador.'
                    ], 401);
                }
            } else {
                //ruta completa del usuario en el directorio prueba (estudiantes)
                $user = "uid=" . $usuario . ",ou=usuarios,dc=utp";
                if (@ldap_bind($ds, $user, $password)) {
                    return response()->json([
                        'title' => 'Usuario Incorrecto', 'detailed' => 'El usuario es un estudiante.'
                    ], 401);
                } else {
                    return response()->json([
                        'title' => 'Usuario/Contraseña Incorrecta', 'detailed' => 'Error en la validación de los datos.'
                    ], 401);
                }
            }
        } else {
            ldap_close($ds);
            // En el caso que no se conecte con el servidor ldap
            // Log::info('Falló conexión servidor LDAP');
            return response()->json([
                'title' => 'Error LDAP', 'detailed' => 'No se pudo establecer conexión con el servidor LDAP.'
            ], 401);
        }
    }


    public function admin_loginback(Request $request)
    {
        $LOGIN = DB::connection('oracleCRIE')->select("
        SELECT * FROM administradores WHERE NICK = '" . $request->input("nick") . "' AND PASSWORD = '".$request->input("password")."' AND ROL_ID = 1");

        if(count($LOGIN) > 0){
            $DateAndTime = new Datetime('America/Bogota');
            $fecha = $DateAndTime->format('Y-m-d H:i:s');
            $expiracion = $DateAndTime->modify('+3 years')->format('Y-m-d H:i:s');

            $token = base64_encode($expiracion .".".$request->input("nick"));
            DB::connection('oracleCRIE')->insert("
                INSERT INTO Token (
                    idtercero,
                    token,
                    fecha,
                    expiracion,
                    rol
                )VALUES(
                    'BYAPP',
                    '".$token."',
                    TO_TIMESTAMP('".$fecha."', 'YYYY-MM-DD HH24:MI:SS'),
                    TO_TIMESTAMP('".$expiracion."', 'YYYY-MM-DD HH24:MI:SS'),
                    '1000'
                )
            ");

            return response()->json([
                'token' =>  $token], 200);
        }else{
            return response()->json([
                'title' => 'No se pudo iniciar sesión', 'detailed' => 'Usuario o contraseña incorrecto.'
            ], 200);
        }

    }
}
