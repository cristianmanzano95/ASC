<!DOCTYPE html>
<html>
<head>
    <title>Recurso re-asignado.</title>
</head>
<body>
    <h1>Hola, {{$formulario['nombre']}}.</h1>
    <p>Se ha realizado un cambio en su solicitud para {{$formulario['nombre_asignatura']}} - COD {{$formulario['codigo_asignatura']}} fue aceptada y asignada de la siguiente manera:</p>
    <p>&nbsp;</p>
    @foreach ($horarios as $value) 

    @if($value->dia == 1)
        <p>Día: Lunes</p>
    @endif
    @if($value->dia == 2)
        <p>Día: Martes</p>
    @endif
    @if($value->dia == 3)
        <p>Día: Miercoles</p>
    @endif
    @if($value->dia == 4)
        <p>Día: Jueves</p>
    @endif
    @if($value->dia == 5)
        <p>Día: Viernes</p>
    @endif
    @if($value->dia == 6)
       <p>Día: Sábado</p>
    @endif
    @if($value->dia == 7)
        <p>Día: Domingo</p>
    @endif
        <p>Hora de inicio: {{$value->hora_inicio}}</p>
        <p>Hora de fin: {{$value->hora_fin}}</p>
        @if($value->recurso_id == null)
        <p>Recurso: Sin recurso disponible</p>
        @else
        <p>Recurso: {{$value->recurso_id}}</p>
        @endif
        <p>&nbsp;</p>

    @endforeach 
   
    <p>Thank you</p>
</body>
</html>