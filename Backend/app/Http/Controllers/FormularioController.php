<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class FormularioController extends Controller
{
    //Crea un formulario
    public function create(Request $request)
    {
    // Si no tiene horarios, retorna error
        if(count($request->input('Horarios')) == 0){
            return response()->json([
                'title' => 'No hay horarios', 'detailed' => 'No se agregaron horarios a la solicitud.'
            ], 401);
        }
        // Si la fecha inicio y fin de la solicitud es la misma, valida que el día en el horario si sea el día que corresponde a esa fecha.
        if($request->input('fecha_solicitud_inicio') == $request->input('fecha_solicitud_fin')){
            $dayofweek = date('w', strtotime($request->input('fecha_solicitud_inicio') ));

            foreach($request->input('Horarios') as $horario){

                if($dayofweek != $horario['dia']){
                    return response()->json([
                        'title' => 'Día invalido', 'detailed' => 'En la fecha solicitada no se encuentra el día.'
                    ], 401);
                    return response()->json( $dayofweek,201);
                }
            }
        }

        //Crea el formulario

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
                parlantes,
                videobeam,
                so,
                link,
                remota,
                observaciones,
                tipo_formulario,
                tipo_cubiculo
            ) VALUES (
            '".intval($request->User[0]->idtercero)."',
            LOWER('".$request->input('nombre')."'),
            LOWER('".$request->input('programa_docente')."'),
            LOWER('".$request->input('documento')."'),
            LOWER('".$request->input('correo_utp')."'),
            LOWER('".$request->input('correo_alt')."'),
            LOWER('".$request->input('codigo_asignatura')."'),
            LOWER('".$request->input('nombre_asignatura')."'),
            '".$request->input('grupo')."',
            '".$request->input('fecha_solicitud_inicio')."',
            '".$request->input('fecha_solicitud_fin')."',
            '".$request->input('cantidad_estudiantes')."',
            LOWER('".$request->input('software_necesario')."'),
            '".($request->input('parlantes')==false?"0":"1")."',
            '".($request->input('videobeam')==false?"0":"1")."',
            '".$request->input('so')."',
            '".$request->input('link')."',
            '".($request->input('remota')==false?"0":"1")."',
            LOWER('".$request->input('observaciones')."'),
            '".$request->input('tipo_formulario')."',
            '".$request->input('tipo_cubiculo')."'
            )");

            //Busca el id del ultimo formulario insertado.
            $id = DB::connection('oracleCRIE')->select("select max(formulario_id) AS id from Formulario");
            //Si fue exitosa la creación del formulario, crea los horarios para ese formulario
            if($CRIE){
                $HorarioArray = array();
                foreach($request->input('Horarios') as $horario){
                    $HorarioLog = DB::connection('oracleCRIE')->insert("
                    INSERT INTO Horario (
                        formulario_id,
                        dia,
                        hora_inicio,
                        hora_fin,
                        recurso_id
                    )VALUES(
                        ".intval($id[0]->id).",
                        '".$horario['dia']."',
                        '".$horario['hora_inicio']."',
                        '".$horario['hora_fin']."',
                        '".intval($horario['cubiculo'])."'
                    )");
                        array_push($HorarioArray, $HorarioLog);
                        }

                    print_r($HorarioArray);
                    }
        return response()->json(201);
    }

    //Actualiza cualquier campo u horario de una solicitud, siempre que el estado de esta sea PENDIENTE.
    public function update(Request $request)
    {
        //Trae el formulario
        $formulario = DB::connection('oracleCRIE')->select("
        SELECT ESTADO FROM FORMULARIO WHERE FORMULARIO_ID = ".$request->input('formulario_id')."
        ");
        //Si no encuentra el formulario, retorna error.
        if(!$formulario){
            return response()->json(['title' => 'No existe', 'detailed' => 'No existe el formulario'], 409);
        }

        $formulario = $formulario[0];

        //Valida que el estado sea PENDIENTE
        if($formulario->estado == '¨PENDIENTE'){
            return response()->json(['title' => 'No se puede modificar', 'detailed' => 'El estado del formulario no permite modificarlo'], 401);
        }

        //Actualiza todos los campos que se envian por el cuerpo de la petición
        DB::connection('oracleCRIE')->table('Formulario')
        ->where('formulario_id', $request->input('formulario_id'))
        ->update($request->except(['Horarios', 'formulario_id', 'User']));


        //Si envía horarios
        if($request->input('Horarios')){
            //Elimina los existentes para este formulario
            DB::connection('oracleCRIE')->table('Horario')->where('formulario_id', $request->input('formulario_id'))->delete();
            //Crea nuevos horarios
            foreach($request->input('Horarios') as $horario){
                DB::connection('oracleCRIE')->insert("
                INSERT INTO Horario (
                    formulario_id,
                    dia,
                    hora_inicio,
                    hora_fin
                )VALUES("
                    .$request->input('formulario_id').",'"
                    .$horario['dia']."','"
                    .$horario['hora_inicio']."','"
                    .$horario['hora_fin']."'
                )");
            }
        }

        return response()->json(200);
    }

    //Lista las solicitudes del usuario logueado.
    public function select(Request $request)
    {
        //Variable para hacer la paginación
        $limit = $request->header('limit') ? $request->header('limit') : 100;
        $page = $request->header('page') && $request->header('page') > 0 ? $request->header('page') : 1;
        $skip = ($page - 1) * $limit;
        $limit = $limit + $skip;
        // error_log($page);


        //Se define los filtros
        $filtros = '';
        if($request->input('codigo_asignatura')){
            $filtros = $filtros." AND  codigo_asignatura LIKE '%".strtolower($request->input('codigo_asignatura'))."%' ";
        }

        if($request->input('nombre_asignatura')){
            $filtros = $filtros." AND  nombre_asignatura LIKE '%".strtolower($request->input('nombre_asignatura'))."%' ";
        }

        if($request->input('grupo')){
            $filtros = $filtros." AND  grupo LIKE '%".strtolower($request->input('grupo'))."%' ";
        }

        if($request->input('fecha_solicitud_fin')){
            $filtros = $filtros." AND  fecha_solicitud_fin <= '".strtolower($request->input('fecha_solicitud_fin'))."' ";
        }

        if($request->input('fecha_solicitud_inicio')){
            $filtros = $filtros." AND  fecha_solicitud_inicio >= '".strtolower($request->input('fecha_solicitud_inicio'))."' ";
        }

        if($request->input('tipo_formulario')){
            $filtros = $filtros." AND  tipo_formulario LIKE '%".$request->input('tipo_formulario')."%' ";
        }

        //Se hace la consulta a la base de datos paginando y aplicando los filtros
        $data = DB::connection('oracleCRIE')->select("
        select * from
        ( select a.*, ROWNUM rnum from
        ( SELECT * FROM Formulario
        WHERE IDTERCERO = ".$request->User[0]->idtercero.$filtros."
        ORDER BY formulario_id) a
        where ROWNUM <= ".$limit." )
        where rnum  > ".$skip."
        ORDER BY fecha_solicitud desc
        ");
        //Se saca un contador para saber el tamaño total de la consulta (sin paginar)
        $count = DB::connection('oracleCRIE')->select("
        SELECT count(*) AS COUNT FROM Formulario
        WHERE IDTERCERO = ".$request->User[0]->idtercero.$filtros."
        ");
        //Se agregan los horarios para cada formulario y se organizan los datos en un nuevo array antes de ser enviado
        $response = [];
        $response1 = [];
        $contador_rechazados = 0;
        foreach($data as $form){
            $horarios = DB::connection('oracleCRIE')->select("
            SELECT * FROM Horario
            WHERE formulario_id = ".$form->formulario_id);
            $h = array();
            $rechazados = array();
            foreach($horarios as $horario){
                if($horario->recurso_id){
                    $recurso = DB::connection('oracleCRIE')->select("SELECT nombre
                        from recursos
                        where id = ".$horario->recurso_id."
                    ");
                    $horario->recurso_id = $recurso[0]->nombre;
                }
                if($form->estado == 'CONFIRMADO' && $horario->recurso_id == null){
                    array_push($rechazados, $horario);
                }else{
                    array_push($h, $horario);
                }
            }
            if(count($rechazados) > 0){
                $contador_rechazados +=1;
                $temp = (array)$form;
                $temp['Horarios'] = $rechazados;
                $temp['estado'] = 'SIN RECURSO DISPONIBLE';
                $response[] = $temp;
            }
            if(count($h)>0){
                $form->Horarios = $h;
                $response[] = (array)$form;
            }
        }

        return response()->json(["count" => $count[0]->count + $contador_rechazados,
                        'data' =>  $response
        ], 200);
    }

    //Lista de los tipo de cubiculos
    public function lista_tipocubiculos(Request $request)
    {
        //Consulta para sacar los grupos de cubiculos (tipo_id = 6)
        $lista = DB::connection('oracleCRIE')->select("SELECT id, nombre
            from recursos where tipo_id = 6 and id != 3
        ");
        return response()->json($lista , 200);
    }

    //Lista de cubiculos según tipo
    public function lista_cubiculos(Request $request)
    {
        //Consulta para retornar los cubiculos para un grupo especifico, excluyendo los ids de los otros grupos y el del equipo del monitor.
        $lista = DB::connection('oracleCRIE')->select("SELECT id, Nombre
        from recursos where grupo_id = ".$request->input("tipo_id")." and id NOT IN (11,723,724,725,726,970,971,972)
        ");
        return response()->json($lista , 200);
    }

    public function lista_programas(Request $request)
    {
        //Consulta para retornar los cubiculos para un grupo especifico, excluyendo los ids de los otros grupos y el del equipo del monitor.
        $lista = DB::connection('oracleUTP')->select("SELECT Nombre FROM REGISTRO.VI_RYC_PROGSOLSALAS WHERE ACTIVO = 1");
        $response = [];
        foreach($lista as $l){
            $response[] = $l->nombre;
        }
        return response()->json($response , 200);
    }


    public function lista_asignaturas(Request $request)
    {
        $codigoUpper = strtoupper($request->codigo);
        // $codigoUpper = $request->codigo;
        //Consulta para retornar los cubiculos para un grupo especifico, excluyendo los ids de los otros grupos y el del equipo del monitor.
        $lista = DB::connection('oracleUTP')->select("SELECT * FROM REGISTRO.VI_RYC_ASIGNATURAS_CRIE WHERE CODIGO LIKE '%".$codigoUpper."%'");
        $response = [];
        foreach($lista as $l){
            $response[] = ["ASIGNATURA" => $l->asignatura, "CODIGO" => $l->codigo];
        }
        return response()->json($response , 200);
    }
//Listar recursos
    // public function lista_recursos(Request $request)
    // {
    //     //Consulta para retornar los recursos, especificamente el nuevonombre.
    //     $lista = DB::connection('oracleCRIE')->select("SELECT ID, nuevonombre FROM RECURSOS");
    //     $response = [];
    //     foreach($lista as $l){
    //         $response[] = $l->nuevonombre;
    //     }
    //     return response()->json($response , 200);
    // }
}
