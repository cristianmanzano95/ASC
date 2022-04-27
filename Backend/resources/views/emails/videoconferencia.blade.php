<!DOCTYPE html>
<html>
<head>
    <title>Recurso asignado.</title>
</head>
<body>
    <h1>Hola, {{$formulario['nombre']}}.</h1>
    <p>Se ha realizado un cambio en su solicitud para {{$formulario['nombre_asignatura']}} - COD {{$formulario['codigo_asignatura']}} fue aceptada y asignada de la siguiente manera:</p>
    <p>&nbsp;</p>
  
    Para la sala : {{$formulario['tipo_cubiculo']}}
   
    <p>Thank you</p>
</body>
</html>