<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //Lista las solicitudes pendientes
    public function pendientes(Request $request)
    {
        //Define las variables para ordenar
        $order = $request->header('order') ? $request->header('order') : 'fecha_solicitud';
        $order_type = $request->header('order_type') ? $request->header('order_type') : 'ASC';


        //Define variables para hacer paginado
        $limit = $request->header('limit') ? $request->header('limit') : 100;
        $page = $request->header('page') && $request->header('page') > 0 ? $request->header('page') : 1;

        $skip = ($page - 1) * $limit;
        $limit = $limit + $skip;

        //Define filtros para la consulta a la base de datos.
        $filtros = '';

        if($request->input('codigo_asignatura')){
            $filtros = $filtros." AND  codigo_asignatura LIKE '%".strtolower($request->input('codigo_asignatura'))."%' ";
        }

        if($request->input('correo_utp')){
            $filtros = $filtros." AND  correo_utp LIKE '%".strtolower($request->input('correo_utp'))."%' ";
        }

        if($request->input('documento')){
            $filtros = $filtros." AND  documento LIKE '%".strtolower($request->input('documento'))."%' ";
        }

        if($request->input('tipo_formulario')){
            $filtros = $filtros." AND  tipo_formulario LIKE '%".$request->input('tipo_formulario')."%' ";
        }

        //Trae la lista de datos paginados y con los filtros aplicados.
        $data = DB::connection('oracleCRIE')->select("
        select * from
        ( select a.*, ROWNUM rnum from
        ( SELECT * FROM Formulario WHERE ESTADO = 'PENDIENTE'".$filtros."
        ORDER BY FECHA_SOLICITUD, ESTADO DESC) a
        where ROWNUM <= ".$limit." )
        where rnum  > ".$skip."
        ORDER BY ".$order." ".$order_type."
        ");

        // Contador para saber el tamaño de los datos
        $count = DB::connection('oracleCRIE')->select("
        SELECT count(*) AS COUNT FROM Formulario WHERE ESTADO = 'PENDIENTE'".$filtros."
        ");

        //Trae los horarios por cada formulario y organiza los datos antes de ser enviados.

        $response = [];
        foreach($data as $form){
            $horarios = DB::connection('oracleCRIE')->select("
                        SELECT * FROM Horario
                        WHERE formulario_id = ".$form->formulario_id."
                        ORDER BY dia");
            if($form->tipo_formulario == "2"){
                $cubiculo = DB::connection('oracleCRIE')->select("
                        SELECT id, nombre FROM recursos
                        WHERE id = ".$form->tipo_cubiculo."
                        ");
                $cubiculo = $cubiculo[0];
                $form->tipo_cubiculo = $cubiculo->nombre;
            }
            $form->Horarios = $horarios;
            $response[] = (object)$form;
        }

        return response()->json(["count" => $count[0]->count,
                        'data' =>  $response
        ], 200);
    }

    //Lista las solicitudes asignadas
    public function asignadas(Request $request)
    {
        //Define las variables para ordenar
        $order = $request->header('order') ? $request->header('order') : 'fecha_solicitud';
        $order_type = $request->header('order_type') ? $request->header('order_type') : 'ASC';


        //Define variables para hacer paginado
        $limit = $request->header('limit') ? $request->header('limit') : 100;
        $page = $request->header('page') && $request->header('page') > 0 ? $request->header('page') : 1;
        $skip = ($page - 1) * $limit;
        $limit = $limit + $skip;

        //Define los filtros que se van a aplicar
        $filtros = '';

        if($request->input('codigo_asignatura')){
            $filtros = $filtros." AND  codigo_asignatura LIKE '%".strtoupper($request->input('codigo_asignatura'))."%' ";
        }

        if($request->input('correo_utp')){
            $filtros = $filtros." AND  correo_utp LIKE '%".strtolower($request->input('correo_utp'))."%' ";
        }

        if($request->input('documento')){
            $filtros = $filtros." AND  documento LIKE '%".strtolower($request->input('documento'))."%' ";
        }

        if($request->input('tipo_formulario')){
            $filtros = $filtros." AND  tipo_formulario LIKE '%".$request->input('tipo_formulario')."%' ";
        }

        //Trae los formulario con el paginado y con los filtros
        $data = DB::connection('oracleCRIE')->select("
        select * from
        ( select a.*, ROWNUM rnum from
        ( SELECT * FROM Formulario WHERE ESTADO = 'ASIGNADO'".$filtros."
        ORDER BY FECHA_SOLICITUD, ESTADO DESC) a
        where ROWNUM <= ".$limit." )
        where rnum  > ".$skip."
        ORDER BY ".$order." ".$order_type."
        ");

        // Contador para saber el tamaño de los datos
        $count = DB::connection('oracleCRIE')->select("
        SELECT count(*) AS COUNT FROM Formulario WHERE ESTADO = 'ASIGNADO'".$filtros."
        ");

        //Trae los horarios por cada formulario y organiza los datos antes de ser enviados.
        $response = [];
        foreach($data as $form){
            $horarios = DB::connection('oracleCRIE')->select("
                        SELECT * FROM Horario
                        WHERE formulario_id = ".$form->formulario_id."
                        ORDER BY dia
                    ");
            $h = array();

            foreach($horarios as $horario){
                if($form->tipo_formulario == '1' && $form->tipo_cubiculo != null){
                    $horario->recurso_id = $form->tipo_cubiculo;
                }else{
                    if(strlen($horario->recurso_id)>0){
                        $recurso = DB::connection('oracleCRIE')->select("SELECT nombre
                            from recursos
                            where id = ".$horario->recurso_id."
                        ");
                        $horario->recurso_id = $recurso[0]->nombre;
                    }
                }
                array_push($h, $horario);
            }
            if($form->tipo_formulario == "2"){
                $cubiculo = DB::connection('oracleCRIE')->select("
                        SELECT id, nombre FROM recursos
                        WHERE id = ".$form->tipo_cubiculo."
                        ");
                $cubiculo = $cubiculo[0];
                $form->tipo_cubiculo = $cubiculo->nombre;
            }

            $form->Horarios = $h;
            $response[] = (object)$form;
        }

        return response()->json(["count" => $count[0]->count,
                        'data' =>  $response
        ], 200);
    }

    //Lista los formularios confirmados
    public function confirmadas(Request $request)
    {
        //Define las variables para ordenar
        $order = $request->header('order') ? $request->header('order') : 'fecha_solicitud';
        $order_type = $request->header('order_type') ? $request->header('order_type') : 'ASC';


        //Define variables para hacer paginado
        $limit = $request->header('limit') ? $request->header('limit') : 100;
        $page = $request->header('page') && $request->header('page') > 0 ? $request->header('page') : 1;
        $skip = ($page - 1) * $limit;
        $limit = $limit + $skip;

        //Define los filtros que se van a aplicar
        $filtros = '';

        if($request->input('codigo_asignatura')){
            $filtros = $filtros." AND  codigo_asignatura LIKE '%".strtolower($request->input('codigo_asignatura'))."%' ";
        }

        if($request->input('correo_utp')){
            $filtros = $filtros." AND  correo_utp LIKE '%".strtolower($request->input('correo_utp'))."%' ";
        }

        if($request->input('documento')){
            $filtros = $filtros." AND  documento LIKE '%".strtolower($request->input('documento'))."%' ";
        }

        if($request->input('tipo_formulario')){
            $filtros = $filtros." AND  tipo_formulario LIKE '%".$request->input('tipo_formulario')."%' ";
        }

        //Trae los formulario con el paginado y con los filtros
        $data = DB::connection('oracleCRIE')->select("
        select * from
        ( select a.*, ROWNUM rnum from
        ( SELECT * FROM Formulario WHERE ESTADO = 'CONFIRMADO'".$filtros."
        ORDER BY FECHA_SOLICITUD, ESTADO DESC) a
        where ROWNUM <= ".$limit." )
        where rnum  > ".$skip."
        ORDER BY ".$order." ".$order_type."
        ");

        // Contador para saber el tamaño de los datos
        $count = DB::connection('oracleCRIE')->select("
        SELECT count(*) AS COUNT FROM Formulario WHERE ESTADO = 'CONFIRMADO'".$filtros."
        ");

        //Trae los horarios por cada formulario y organiza los datos antes de ser enviados.
        $response = [];
        foreach($data as $form){

            $horarios = DB::connection('oracleCRIE')->select("
                        SELECT * FROM HORARIO
                        WHERE formulario_id = ".$form->formulario_id." AND recurso_id is not null
                        ORDER BY dia"
                    );
            $h = array();

            foreach($horarios as $horario){
                if($form->tipo_formulario == '1' && $form->tipo_cubiculo != null){
                    $horario->recurso_id = $form->tipo_cubiculo;
                }else{
                    $recurso = DB::connection('oracleCRIE')->select("SELECT nombre
                        from recursos
                        where id = ".$horario->recurso_id."
                    ");
                    $horario->recurso_id = $recurso[0]->nombre;
                }
                array_push($h, $horario);
            }
            if($form->tipo_formulario == "2"){
                $cubiculo = DB::connection('oracleCRIE')->select("
                        SELECT id, nombre FROM recursos
                        WHERE id = ".$form->tipo_cubiculo."
                        ");
                $cubiculo = $cubiculo[0];
                $form->tipo_cubiculo = $cubiculo->nombre;
            }
            if(count($horarios) > 0){
                $form->Horarios = $h;
                $response[] = (object)$form;
            }
        }

        return response()->json(["count" => $count[0]->count,
                        'data' =>  $response
        ], 200);
    }

    //Lista los formularios que tienen horarios rechazados
    public function rechazadas(Request $request)
    {
        //Define las variables para ordenar
        $order = $request->header('order') ? $request->header('order') : 'fecha_solicitud';
        $order_type = $request->header('order_type') ? $request->header('order_type') : 'ASC';


        //Define variables para hacer paginado
        $limit = $request->header('limit') ? $request->header('limit') : 100;
        $page = $request->header('page') && $request->header('page') > 0 ? $request->header('page') : 1;
        $skip = ($page - 1) * $limit;
        $limit = $limit + $skip;

        //Define los filtros que se van a aplicar
        $filtros = '';

        if($request->input('codigo_asignatura')){
            $filtros = $filtros." AND  codigo_asignatura LIKE '%".strtolower($request->input('codigo_asignatura'))."%' ";
        }

        if($request->input('correo_utp')){
            $filtros = $filtros." AND  correo_utp LIKE '%".strtolower($request->input('correo_utp'))."%' ";
        }

        if($request->input('documento')){
            $filtros = $filtros." AND  documento LIKE '%".strtolower($request->input('documento'))."%' ";
        }

        if($request->input('tipo_formulario')){
            $filtros = $filtros." AND  tipo_formulario LIKE '%".$request->input('tipo_formulario')."%' ";
        }

        //Trae los formulario con el paginado y con los filtros
        $data = DB::connection('oracleCRIE')->select("
        select * from
        ( select a.*, ROWNUM rnum from
        ( SELECT * FROM Formulario WHERE ESTADO = 'CONFIRMADO' AND formulario_id IN (SELECT formulario_id FROM Horario WHERE recurso_id is null) ".$filtros."
        ORDER BY FECHA_SOLICITUD, ESTADO DESC) a
        where ROWNUM <= ".$limit." )
        where rnum  > ".$skip."
        ORDER BY ".$order." ".$order_type."
        ");

        // Contador para saber el tamaño de los datos
        $count = DB::connection('oracleCRIE')->select("
        SELECT count(*) AS COUNT FROM Formulario WHERE ESTADO = 'CONFIRMADO' AND formulario_id IN (SELECT formulario_id FROM Horario WHERE recurso_id is null) ".$filtros."
        ");

        //Trae los horarios por cada formulario y organiza los datos antes de ser enviados.
        $response = [];
        foreach($data as $form){
            $horarios = DB::connection('oracleCRIE')->select("
                        SELECT * FROM Horario
                        WHERE formulario_id = ".$form->formulario_id." AND recurso_id is null
                        ORDER BY dia");
            $h = array();

            foreach($horarios as $horario){
                array_push($h, $horario);
            }
            if($form->tipo_formulario == "2"){
                $cubiculo = DB::connection('oracleCRIE')->select("
                        SELECT id, nombre FROM recursos
                        WHERE id = ".$form->tipo_cubiculo."
                        ");
                $cubiculo = $cubiculo[0];
                $form->tipo_cubiculo = $cubiculo->nombre;
            }
            $form->Horarios = $h;
            $response[] = (object)$form;
        }

        return response()->json(["count" => $count[0]->count,
                        'data' =>  $response
        ], 200);
    }

    //Listado de salas disponibles según el horario con los filtros requeridos y no permitiendo cruce de horarios.
    public function namerooms(Request $request)
    {

        //Trae el formulario
        $formulario = DB::connection('oracleCRIE')->select("SELECT nombre
            from Recursos
            where id = ".intval($request->input('recurso_id')));
        $formulario = $formulario[0];

        // print_r($formulario);

        // $rooms = array();

        // foreach ($data as $i => $sala)
        // {
        //     array_push($rooms, $sala->nombre);
        // }
        return response()->json($formulario , 200);
    }
    public function rooms(Request $request)
    {

        //Trae el formulario
        $formulario = DB::connection('oracleCRIE')->select("SELECT *
            from Formulario
            where formulario_id = ".intval($request->input('formulario_id')));
        $formulario = $formulario[0];
        //print_r($formulario);
        // (
        //     [formulario_id] => 127
        //     [idtercero] => 494801
        //     [nombre] => cristian camilo manzano calvo
        //     [programa_docente] => ingeniería de sistemas y  computación
        //     [documento] => 1088324977
        //     [correo_utp] => ccmanzano@utp.edu.co
        //     [correo_alt] => cris.635@utp.edu.co
        //     [codigo_asignatura] => is923
        //     [nombre_asignatura] => comunicaciones iii
        //     [grupo] => 2
        //     [fecha_solicitud_inicio] => 2022-05-31 00:00:00
        //     [fecha_solicitud_fin] => 2022-06-02 00:00:00
        //     [cantidad_estudiantes] => 6
        //     [software_necesario] =>
        //     [parlantes] => 1
        //     [videobeam] => 1
        //     [estado] => PENDIENTE
        //     [observaciones] =>
        //     [tipo_formulario] => 0
        //     [tipo_cubiculo] =>
        //     [fecha_solicitud] => 2022-05-31 10:05:41
        //     [so] =>
        //     [link] =>
        //     [remota] => 1
        //     [cambio] => 0
        // )


        //Si no encuentra el formulario, retorna error.
        if(!$formulario){
            return response()->json(['title' => 'No existe', 'detailed' => 'No existe el formulario'], 409);
        }

        //Agrega a los filtros las condiciones de parlantes, videobeam y remota
        $filtros = '';
        if($formulario->parlantes == 15){
            $filtros = $filtros." AND parlantes = 15";
        }

        if(intval($formulario->videobeam) == 16){
            $filtros = $filtros." AND videobeam = 16";
        }

        if(intval($formulario->remota) == 24){
            $filtros = $filtros." AND remota = 24";
        }

        //Trae los horarios
        $horarios = DB::connection('oracleCRIE')->select("SELECT *
            from Horario
            where horario_id = ".intval($request->input('horario_id')));
        $horario = $horarios[0];
        // print_r($horario);

        // (
        //     [horario_id] => 56
        //     [formulario_id] => 127
        //     [dia] => 2
        //     [recurso_id] =>
        //     [hora_inicio] => 7:00
        //     [hora_fin] => 8:00
        // )

        // Trae la lista de horarios
        if(!$horario){
            return response()->json(['title' => 'No existe', 'detailed' => 'No existe el horario'], 409);
        }

        // Asigna la variable dia
        $dia = $horario->dia;
        if ($dia == '1'){$dia = 'monday';}
        if ($dia == '2'){$dia = 'tuesday';}
        if ($dia == '3'){$dia = 'wednesday';}
        if ($dia == '4'){$dia = 'thursday';}
        if ($dia == '5'){$dia = 'friday';}
        if ($dia == '6'){$dia = 'saturday';}
        if ($dia == '7'){$dia = 'sunday';}
        //DB::connection('oracleCRIE')->enableQueryLog();

        $data = 0;
        // Hace la consulta según el tipo de formulario 0- SALA 1- CUBICULO 2-VIDECONFERENCIA
        //  if ($formulario->tipo_formulario == '0'){
        //      $data = DB::connection('oracleCRIE')->select("
        //      SELECT nombre
        //      FROM recursos
        //      WHERE tipo_id = 3 AND cantidad_estudiantes >= ".intval($formulario->cantidad_estudiantes).$filtros." AND id NOT IN (64, 122)
        //      ORDER BY nombre asc"
        //      );
        //}
            //print_r("Aqui va el filtro");
            //print_r($filtros);
        //  print_r("Aqui data");
        //  print_r($data);

            if ($formulario->tipo_formulario == '0'){
             $data = DB::connection('oracleCRIE')->select("
             SELECT nombre
              FROM recursos
              WHERE id NOT IN (
                  SELECT B.id
                  FROM prestamos A
                  JOIN recursos B ON (A.recurso_id = B.id)
                  WHERE A.fecha >= to_date('".explode(' ',$formulario->fecha_solicitud_inicio)[0]."','yyyy-mm-dd') and
                          A.fecha <= to_date('".explode(' ',$formulario->fecha_solicitud_fin)[0]."','yyyy-mm-dd') and
                          to_char(A.fecha,'fmday','nls_date_language = AMERICAN') = '".$dia."' and
                          A.estado! = 'N' and
                          CASE WHEN to_timestamp('".$horario->hora_inicio."','HH24-MI') > to_timestamp(to_char(A.hora_inicio,'HH24-MI'),'HH24-MI') THEN to_timestamp('".$horario->hora_inicio."','HH24-MI') ELSE to_timestamp(to_char(A.hora_inicio,'HH24-MI'),'HH24-MI') END <
                          CASE WHEN to_timestamp('".$horario->hora_fin."','HH24-MI') < to_timestamp(to_char(A.hora_fin,'HH24-MI'),'HH24-MI') THEN to_timestamp('".$horario->hora_fin."','HH24-MI') ELSE to_timestamp(to_char(A.hora_fin,'HH24-MI'),'HH24-MI') END AND
                          B.tipo_id = 3
              ) AND tipo_id = 3 AND cantidad_estudiantes >= ".intval($formulario->cantidad_estudiantes).$filtros." AND id NOT IN (64, 122)
              ORDER BY nombre asc"
              );
          }


        // print_r("Hola soy el filtro");

        if ($formulario->tipo_formulario == '2'){
            $data = DB::connection('oracleCRIE')->select("
            SELECT nombre
            FROM recursos
            WHERE id NOT IN (
                SELECT B.id
                FROM prestamos A
                JOIN recursos B ON (A.recurso_id = B.id)
                WHERE A.fecha >= to_date('".explode(' ',$formulario->fecha_solicitud_inicio)[0]."','yyyy-mm-dd') and
                        A.fecha <= to_date('".explode(' ',$formulario->fecha_solicitud_fin)[0]."','yyyy-mm-dd') and
                        to_char(A.fecha,'fmday','nls_date_language = AMERICAN') = '".$dia."' and
                        A.estado! = 'N' and
                        CASE WHEN to_timestamp('".$horario->hora_inicio."','HH24-MI') > to_timestamp(to_char(A.hora_inicio,'HH24-MI'),'HH24-MI') THEN to_timestamp('".$horario->hora_inicio."','HH24-MI') ELSE to_timestamp(to_char(A.hora_inicio,'HH24-MI'),'HH24-MI') END <
                        CASE WHEN to_timestamp('".$horario->hora_fin."','HH24-MI') < to_timestamp(to_char(A.hora_fin,'HH24-MI'),'HH24-MI') THEN to_timestamp('".$horario->hora_fin."','HH24-MI') ELSE to_timestamp(to_char(A.hora_fin,'HH24-MI'),'HH24-MI') END AND
                        B.tipo_id = 2 AND A.grupo_id = ".$formulario->tipo_cubiculo."
            ) AND tipo_id = 2 AND grupo_id = ".$formulario->tipo_cubiculo."ORDER BY nombre asc"
            );
        }
        if ($formulario->tipo_formulario == '1'){
                $data = DB::connection('oracleCRIE')->select("
                SELECT nombre
                FROM recursos
                WHERE id NOT IN (
                    SELECT B.id
                    FROM prestamos A
                    JOIN recursos B ON (A.recurso_id = B.id)
                    WHERE A.fecha >= to_date('".explode(' ',$formulario->fecha_solicitud_inicio)[0]."','yyyy-mm-dd') and
                            A.fecha <= to_date('".explode(' ',$formulario->fecha_solicitud_fin)[0]."','yyyy-mm-dd') and
                            to_char(A.fecha,'fmday','nls_date_language = AMERICAN') = '".$dia."' and
                            A.estado! = 'N' and
                            CASE WHEN to_timestamp('".$horario->hora_inicio."','HH24-MI') > to_timestamp(to_char(A.hora_inicio,'HH24-MI'),'HH24-MI') THEN to_timestamp('".$horario->hora_inicio."','HH24-MI') ELSE to_timestamp(to_char(A.hora_inicio,'HH24-MI'),'HH24-MI') END <
                            CASE WHEN to_timestamp('".$horario->hora_fin."','HH24-MI') < to_timestamp(to_char(A.hora_fin,'HH24-MI'),'HH24-MI') THEN to_timestamp('".$horario->hora_fin."','HH24-MI') ELSE to_timestamp(to_char(A.hora_fin,'HH24-MI'),'HH24-MI') END AND
                            B.id IN (64,122)
                ) AND id IN (64,122) ".$filtros."ORDER BY nombre asc"
                );
        }

        $rooms = array();

        foreach ($data as $i => $sala)
        {
            array_push($rooms, $sala->nombre);
        }
        return response()->json($rooms , 200);
    }

    //Envía un correo con los recursos asignados o re-asignados (en caso de cambio) al docente o administrativo.
    public function confirmar(Request $request)
    {
        //Trae el formulario
        $formulario = DB::connection('oracleCRIE')->select("SELECT *
            from Formulario
            where formulario_id = ".intval($request->input("formulario_id")));
        $formulario = $formulario[0];
        //Trae la lista de horarios

        if($formulario->tipo_formulario == '1' && $formulario->tipo_cubiculo != null){
            \Mail::to($formulario->correo_utp)->send(new \App\Mail\VideoConferencia($formulario));
            if($formulario->correo_alt){
                \Mail::to($formulario->correo_alt)->send(new \App\Mail\VideoConferencia($formulario));
            }

            DB::connection('oracleCRIE')->table('Formulario')
            ->where('formulario_id', $request->input('formulario_id'))
            ->update(["estado" => "CONFIRMADO", 'cambio' => '0']);
            DB::connection('oracleCRIE')->commit();
            return response(200);
        }
        $horarios =  DB::connection('oracleCRIE')->select("
                SELECT * FROM horario
                WHERE formulario_id = '" .$request->input("formulario_id"). "'
                ");

        $h = array();
        //Agrega el nombre del recurso asignado según su id para mostrarlo en el correo
        foreach($horarios as $horario){
            if(strlen($horario->recurso_id) > 0){
                $recurso = DB::connection('oracleCRIE')->select("SELECT nombre
                    from recursos
                    where id = ".$horario->recurso_id."
                ");
                $horario->recurso_id = $recurso[0]->nombre;
            }
            array_push($h, $horario);
        }
        //Envía el correo
        if($formulario->cambio == 0){
            \Mail::to($formulario->correo_utp)->send(new \App\Mail\Asignar($h, $formulario));
            if($formulario->correo_alt){
                \Mail::to($formulario->correo_alt)->send(new \App\Mail\Asignar($h, $formulario));
            }
        }else{
            \Mail::to($formulario->correo_utp)->send(new \App\Mail\ReAsignar($h, $formulario));
            if($formulario->correo_alt){
                \Mail::to($formulario->correo_alt)->send(new \App\Mail\ReAsignar($h, $formulario));
            }
        }

        //Modifica el estado del formulario
        DB::connection('oracleCRIE')->table('Formulario')
            ->where('formulario_id', $request->input('formulario_id'))
            ->update(["estado" => "CONFIRMADO", 'cambio' => '0']);
        return response(200);
    }

    //Asigna un recurso en el rango de fechas establecido
    public function asignar(Request $request)
    {
        // Comienza una transacción

        DB::connection('oracleCRIE')->beginTransaction();

        try {
            //Trae el formulario
            $formulario = DB::connection('oracleCRIE')->select("SELECT *
                from Formulario
                where formulario_id = ".$request->input("formulario_id")."
            ");
            $formulario = $formulario[0];


            // Ignora
            if($formulario->tipo_formulario == '1' && $formulario->tipo_cubiculo != null){
                DB::connection('oracleCRIE')->table('Formulario')
                ->where('formulario_id', $request->input('formulario_id'))
                ->update(["estado" => "ASIGNADO"]);
                DB::connection('oracleCRIE')->commit();
                return response(200);

            }
            DB::connection('oracleCRIE')->table('prestamos')->where('formulario_id', $request->input('formulario_id'))->delete();
            // Cicla los horarios del cuerpo de la solicitud para insertarlos en la tabla prestamos
            foreach($request->input('Horarios') as $ho){
                if(strlen($ho['recurso_id']) > 0){
                    //busca el id de la sala según el nombre.
                    $recurso =  DB::connection('oracleCRIE')->select("
                    SELECT ID FROM recursos
                    WHERE nombre = '" .$ho['recurso_id']. "'");
                    // print_r("Soy oh");
                    // print_r($recurso);
                    $recurso = $recurso[0];
                    //$recurso = $recurso[0] + $recurso(null);

                    //Actualiza la tabla de horarios para agregar el id de la sala que se asignó.
                    DB::connection('oracleCRIE')->table('horario')
                    ->where('horario_id', $ho['horario_id'])
                    ->update(["recurso_id" => $recurso->id]);

                    // Trae el horario
                    $horario = DB::connection('oracleCRIE')->select("SELECT *
                    from horario
                    where horario_id = ".$ho['horario_id']."
                    ");
                    $horario = $horario[0];

                    $id = $horario->horario_id;

                    //asigna el nombre del día según el numeor en la base de datos.
                    $dia = $horario->dia;
                    if ($dia == '1'){$dia = 'monday';}
                    if ($dia == '2'){$dia = 'tuesday';}
                    if ($dia == '3'){$dia = 'wednesday';}
                    if ($dia == '4'){$dia = 'thursday';}
                    if ($dia == '5'){$dia = 'friday';}
                    if ($dia == '6'){$dia = 'saturday';}
                    if ($dia == '7'){$dia = 'sunday';}

                    $fecha_inicio = strtotime('-1 day', strtotime($formulario->fecha_solicitud_inicio));
                    //el -1 elimina es un dia antes, usado porque por defecto php pone horas y minutos
                    //ademas el strtotime cuando se le hace next al mismo dia, retorna el proximo, por lo que el -1 evita eso
                    $fecha_final = strtotime($formulario->fecha_solicitud_fin);

                    $fecha = strtotime("next $dia", $fecha_inicio);
                    while ($fecha <= $fecha_final) {
                        $fechastr = date('d-m-Y', $fecha);
                        $qstr = "insert into prestamos values(prest_seq.nextval,'".$formulario->codigo_asignatura."','".$formulario->nombre_asignatura."',
                        to_timestamp('".$horario->hora_inicio."','HH24:MI'),
                        to_timestamp('".$horario->hora_fin."','HH24:MI'),
                        to_date('".$fechastr."','DD-MM-YYYY'),
                        'S',".$horario->recurso_id.",null,'".$formulario->documento."',null,".$formulario->formulario_id.")";
                        DB::connection('oracleCRIE')->insert($qstr);
                        $fecha = strtotime("next ".$dia, $fecha);
                    }
                }else{
                    DB::connection('oracleCRIE')->table('horario')
                    ->where('horario_id', $ho['horario_id'])
                    ->update(["recurso_id" => null]);
                }
            }

            //Actualiza el estado del formulario
            if($formulario->estado == 'CONFIRMADO'){
                $horarios =  DB::connection('oracleCRIE')->select("
                SELECT * FROM horario
                WHERE formulario_id = '" .$request->input("formulario_id"). "'
                ");

                $h = array();
                //Agrega el nombre del recurso asignado según su id para mostrarlo en el correo
                foreach($horarios as $horario){
                    $recurso = DB::connection('oracleCRIE')->select("SELECT nombre
                        from recursos
                        where id = ".$horario->recurso_id."
                    ");
                    $horario->recurso_id = $recurso[0]->nombre;
                    array_push($h, $horario);
                }
                //Envía el correo
                \Mail::to($formulario->correo_utp)->send(new \App\Mail\Asignar($h, $formulario));
                if($formulario->correo_alt){
                    \Mail::to($formulario->correo_alt)->send(new \App\Mail\ReAsignar($h, $formulario));
                }
            }else{
                DB::connection('oracleCRIE')->table('Formulario')
                ->where('formulario_id', $request->input('formulario_id'))
                ->update(["estado" => "ASIGNADO"]);
            }


            //Hace un commit de los cambios en base de datos.
            DB::connection('oracleCRIE')->commit();
            return response(200);
        } catch (Exception $ex) {
            // En caso de error en la base de datos, hace un rollback de todos los cambios que hizo dentro de la transacción.
            DB::connection('oracleCRIE')->rollback();
            return response(401);
        }
    }

    //Actualiza el estado de un formulario
    public function update(Request $request)
    {
        //Trae el formulario
        $formulario = DB::connection('oracleCRIE')->select("SELECT *
                from Formulario
                where formulario_id = ".$request->input("formulario_id")."
            ");
        $formulario = $formulario[0];

        //Según la petición, se cambia el estado del formulario y se activa la columna de cambios
        if($request->input("estado") == 'PENDIENTE' && $formulario->estado == 'CONFIRMADO'){
            DB::connection('oracleCRIE')->table('Formulario')
            ->where('formulario_id', $request->input('formulario_id'))->update(['ESTADO' => 'PENDIENTE', 'CAMBIO' => '1']);

            //Elimina la reserva y el recurso asignado en los horarios
            DB::connection('oracleCRIE')->table('horario')
            ->where('formulario_id', $request->input('formulario_id'))->update(['recurso_id' => null]);
            DB::connection('oracleCRIE')->table('prestamos')->where('formulario_id', $request->input('formulario_id'))->delete();
        }else if($request->input("estado") == 'ASIGNADO'){
            DB::connection('oracleCRIE')->table('Formulario')
            ->where('formulario_id', $request->input('formulario_id'))
            ->update(['ESTADO' => 'ASIGNADO', 'CAMBIO' => '1']);

        }else{
            DB::connection('oracleCRIE')->table('Formulario')
            ->where('formulario_id', $request->input('formulario_id'))->update(['ESTADO' => 'PENDIENTE']);

            //Elimina la reserva y el recurso asignado en los horarios
            DB::connection('oracleCRIE')->table('horario')
            ->where('formulario_id', $request->input('formulario_id'))->update(['recurso_id' => null]);
            DB::connection('oracleCRIE')->table('prestamos')->where('formulario_id', $request->input('formulario_id'))->delete();
        }
        return response()->json(200);
    }

    public function masivo_computo(Request $request)
    {
        $file_n = $request->file('csv');
        $fila = 0;
        $data = array();
        $errors = array();
        if (($gestor = fopen($file_n, "r")) !== FALSE) {
            $id = 0;
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                if(count($datos)>0){
                    if($fila > 0){
                        if($datos[0] != ''){

                            $UTP = DB::connection('oracleUTP')->select("
                                SELECT idtercero, nombres, apellidos, numerodocumento, cargo, tipocarnet, programadependencia from ANDOVER.VI_CARNETUTP_ADMINITRATIVO
                                WHERE numerodocumento = '" . $datos[0] . "'
                                UNION
                                SELECT idtercero, nombres, apellidos, numerodocumento, cargo, tipocarnet, programadependencia from ANDOVER.VI_CARNETUTP_DOCENTE
                                WHERE numerodocumento = '" . $datos[0] . "'
                            ");
                            if(count($UTP) > 0){
                                $UTP = $UTP[0];
                                if($datos[0] != ''){
                                    DB::connection('oracleCRIE')->beginTransaction();
                                    try{
                                        //return response()->json($datos[0],200);
                                            $CRIE = DB::connection('oracleCRIE')->insert("
                                                INSERT INTO Formulario(
                                                    idtercero,
                                                    nombre,
                                                    programa_docente,
                                                    documento,
                                                    correo_utp,
                                                    correo_alt,
                                                    codigo_asignatura,
                                                    nombre_asignatura,
                                                    grupo,
                                                    fecha_solicitud_inicio,
                                                    fecha_solicitud_fin,
                                                    cantidad_estudiantes,
                                                    software_necesario,
                                                    so,
                                                    link,
                                                    parlantes,
                                                    remota,
                                                    videobeam,
                                                    observaciones,
                                                    tipo_formulario,
                                                    tipo_cubiculo
                                                ) VALUES (
                                                '".intval($UTP->idtercero)."',
                                                LOWER('".$UTP->nombres." ".$UTP->apellidos."'),
                                                LOWER('".$UTP->programadependencia."'),
                                                LOWER('".$UTP->numerodocumento."'),
                                                LOWER('".$datos[1]."'),
                                                LOWER('".$datos[2]."'),
                                                LOWER('".$datos[3]."'),
                                                LOWER('".$datos[4]."'),
                                                '".$datos[5]."',
                                                '".$datos[6]."',
                                                '".$datos[7]."',
                                                '".$datos[8]."',
                                                LOWER('".$datos[9]."'),
                                                LOWER('".$datos[10]."'),
                                                LOWER('".$datos[11]."'),
                                                '".($datos[12]=='NO'?"0":"1")."',
                                                '".($datos[13]=='NO'?"0":"1")."',
                                                '".($datos[14]=='NO'?"0":"1")."',
                                                LOWER('".$datos[15]."'),
                                                '0',
                                                null
                                            )");
                                            $id = DB::connection('oracleCRIE')->select("select max(formulario_id) AS id from Formulario");

                                            $dia = strtolower($datos[16]);
                                            if ($dia == 'lunes'){$dia = '1';}
                                            if ($dia == 'martes'){$dia = '2';}
                                            if ($dia == 'miercoles'){$dia = '3';}
                                            if ($dia == 'miércoles'){$dia = '3';}
                                            if ($dia == 'jueves'){$dia = '4';}
                                            if ($dia == 'viernes'){$dia = '5';}
                                            if ($dia == 'sabado'){$dia = '6';}
                                            if ($dia == 'sábado'){$dia = '6';}
                                            if ($dia == 'domingo'){$dia = '7';}

                                            if($CRIE){
                                                DB::connection('oracleCRIE')->insert("
                                                INSERT INTO Horario (
                                                    formulario_id,
                                                    dia,
                                                    hora_inicio,
                                                    hora_fin,
                                                    cubiculo
                                                )VALUES("
                                                    .intval($id[0]->id).",'"
                                                    .$dia."','"
                                                    .$datos[17]."','"
                                                    .$datos[18]."',
                                                    null
                                                )");
                                            }
                                            DB::connection('oracleCRIE')->commit();
                                        } catch (Exception $ex) {

                                            DB::connection('oracleCRIE')->rollback();
                                            $datos[] = 'Error en la inserción a la base de datos';
                                            array_push($errors, $datos);
                                            return response(["title"=> "Error en la inserción", "detailed"=> "Se presentó un error - Linea ".$fila],401);
                                        }
                                    }
                                }else{

                                }
                            }
                            else{
                                if($id != 0 && $datos[16] != ''){
                                    $cont = 0;
                                    while($cont < 3){
                                        try{
                                            $dia = strtolower($datos[16]);
                                            if ($dia == 'lunes'){$dia = '1';}
                                            if ($dia == 'martes'){$dia = '2';}
                                            if ($dia == 'miercoles'){$dia = '3';}
                                            if ($dia == 'miércoles'){$dia = '3';}
                                            if ($dia == 'jueves'){$dia = '4';}
                                            if ($dia == 'viernes'){$dia = '5';}
                                            if ($dia == 'sabado'){$dia = '6';}
                                            if ($dia == 'sábado'){$dia = '6';}
                                            if ($dia == 'domingo'){$dia = '7';}
                                            DB::connection('oracleCRIE')->insert("
                                            INSERT INTO Horario (
                                                formulario_id,
                                                dia,
                                                hora_inicio,
                                                hora_fin,
                                                cubiculo
                                            )VALUES("
                                                .intval($id[0]->id).",'"
                                                .$dia."','"
                                                .$datos[17]."','"
                                                .$datos[18]."',
                                                null
                                            )");
                                            DB::connection('oracleCRIE')->commit();
                                            $cont = 3;
                                        } catch (Exception $ex) {
                                            DB::connection('oracleCRIE')->rollback();
                                            $cont ++;

                                        }
                                    }
                                }
                            }
                        }
                    $fila++;
                }
            }

            fclose($gestor);
        }
        return response()->json(201);
    }

    public function masivo_cubiculo(Request $request)
    {
        $file_n = $request->file('csv');
        $fila = 0;
        $data = array();
        $errors = array();
        if (($gestor = fopen($file_n, "r")) !== FALSE) {

            $id = 0;
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                if(count($datos)>0){
                    if($fila > 0){
                        if($datos[0] != ''){

                            $UTP = DB::connection('oracleUTP')->select("
                                SELECT idtercero, nombres, apellidos, numerodocumento, cargo, tipocarnet, programadependencia from ANDOVER.VI_CARNETUTP_ADMINITRATIVO
                                WHERE numerodocumento = '" . $datos[0] . "'
                                UNION
                                SELECT idtercero, nombres, apellidos, numerodocumento, cargo, tipocarnet, programadependencia from ANDOVER.VI_CARNETUTP_DOCENTE
                                WHERE numerodocumento = '" . $datos[0] . "'
                            ");
                            if(count($UTP) > 0){
                                $UTP = $UTP[0];
                                if($datos[0] != ''){
                                    DB::connection('oracleCRIE')->beginTransaction();
                                    try{
                                        if($datos[10] == "Clavinova") {$datos[10] = 723;}
                                        if($datos[10] == "Pianos") {$datos[10] = 724;}
                                        if($datos[10] == "Viento") {$datos[10] = 725;}
                                        if($datos[10] == "Cuerdas") {$datos[10] = 726;}
                                        if($datos[10] == "Primer Piso Marimba") {$datos[10] = 970;}
                                        if($datos[10] == "Primer Piso Gran Formato y Amplificados") {$datos[10] = 971;}
                                        if($datos[10] == "Primer Piso Clavinova") {$datos[10] = 972;}

                                            $CRIE = DB::connection('oracleCRIE')->insert("
                                                INSERT INTO Formulario(
                                                    idtercero,
                                                    nombre,
                                                    programa_docente,
                                                    documento,
                                                    correo_utp,
                                                    correo_alt,
                                                    codigo_asignatura,
                                                    nombre_asignatura,
                                                    grupo,
                                                    fecha_solicitud_inicio,
                                                    fecha_solicitud_fin,
                                                    cantidad_estudiantes,
                                                    observaciones,
                                                    tipo_formulario,
                                                    tipo_cubiculo
                                                ) VALUES (
                                                '".intval($UTP->idtercero)."',
                                                LOWER('".$UTP->nombres." ".$UTP->apellidos."'),
                                                LOWER('".$UTP->programa."'),
                                                LOWER('".$UTP->numdoc."'),
                                                LOWER('".$datos[1]."'),
                                                LOWER('".$datos[2]."'),
                                                LOWER('".$datos[3]."'),
                                                LOWER('".$datos[4]."'),
                                                '".$datos[5]."',
                                                '".$datos[6]."',
                                                '".$datos[7]."',
                                                '".$datos[8]."',
                                                LOWER('".$datos[9]."'),
                                                '2',
                                                '".$datos[10]."'
                                            )");
                                            $id = DB::connection('oracleCRIE')->select("select max(formulario_id) AS id from Formulario");

                                            $dia = strtolower($datos[11]);
                                            if ($dia == 'lunes'){$dia = '1';}
                                            if ($dia == 'martes'){$dia = '2';}
                                            if ($dia == 'miercoles'){$dia = '3';}
                                            if ($dia == 'miércoles'){$dia = '3';}
                                            if ($dia == 'jueves'){$dia = '4';}
                                            if ($dia == 'viernes'){$dia = '5';}
                                            if ($dia == 'sabado'){$dia = '6';}
                                            if ($dia == 'sábado'){$dia = '6';}
                                            if ($dia == 'domingo'){$dia = '7';}

                                            if($CRIE){
                                                DB::connection('oracleCRIE')->insert("
                                                INSERT INTO Horario (
                                                    formulario_id,
                                                    dia,
                                                    hora_inicio,
                                                    hora_fin,
                                                    cubiculo
                                                )VALUES("
                                                    .intval($id[0]->id).",'"
                                                    .$dia."','"
                                                    .$datos[12]."','"
                                                    .$datos[13]."','"
                                                    .$datos[14]."'
                                                )");
                                            }
                                            DB::connection('oracleCRIE')->commit();
                                        }
                                        catch (Exception $ex) {

                                            DB::connection('oracleCRIE')->rollback();
                                            $datos[] = 'Error en la inserción a la base de datos';
                                            array_push($errors, $datos);
                                            return response(["title"=> "Error en la inserción", "detailed"=> "Se presentó un error - Linea ".$fila],401);
                                        }
                                }
                            }
                            else{
                                if($id != 0 && $datos[11] != ''){
                                    $cont = 0;
                                    while($cont < 3){
                                        try{
                                            $dia = strtolower($datos[11]);
                                            if ($dia == 'lunes'){$dia = '1';}
                                            if ($dia == 'martes'){$dia = '2';}
                                            if ($dia == 'miercoles'){$dia = '3';}
                                            if ($dia == 'miércoles'){$dia = '3';}
                                            if ($dia == 'jueves'){$dia = '4';}
                                            if ($dia == 'viernes'){$dia = '5';}
                                            if ($dia == 'sabado'){$dia = '6';}
                                            if ($dia == 'sábado'){$dia = '6';}
                                            if ($dia == 'domingo'){$dia = '7';}
                                            DB::connection('oracleCRIE')->insert("
                                            INSERT INTO Horario (
                                                formulario_id,
                                                dia,
                                                hora_inicio,
                                                hora_fin,
                                                cubiculo
                                            )VALUES("
                                                .intval($id[0]->id).",'"
                                                .$dia."','"
                                                .$datos[12]."','"
                                                .$datos[13]."','"
                                                .$datos[14]."'
                                            )");
                                            DB::connection('oracleCRIE')->commit();
                                            $cont = 3;
                                        } catch (Exception $ex) {
                                            DB::connection('oracleCRIE')->rollback();
                                            $cont ++;

                                        }
                                    }
                                }
                            }
                        }
                    }
                    $fila++;
                }
            }

            fclose($gestor);
        }
        return response()->json(201);
    }


    //Busca un formulario por su id.
    public function find(Request $request)
    {
        // Retorna el formulario con la id que se envía por el cuerpo de la petición.
        $lista = DB::connection('oracleCRIE')->select("SELECT *
        from formulario where formulario_id = ".$request->input("formulario_id")."
        ");
        return response()->json($lista , 200);
    }

}
