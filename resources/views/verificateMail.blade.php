<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/app.css" rel="stylesheet">

    <title>L'Assaig</title>
</head>
<body style="padding: 2em">
<h1 style="color: green; ">Reserva confirmada!</h1>
<p>Nos vemos en el Restaurante L'Assaig el próximo <strong>{{$fecha->fecha}}</strong></p>
<p><strong style="color: red; font-size: 30px">Importante!!</strong> No aceptamos pago con targeta</p>
<h2>Detalles de la reserva:</h2>
<div style="border:gray 1px solid; margin-left: 3em; padding: 1em">
    <p style="color: darkgreen; font-size: 15px">Nombre: <strong style="color: black; font-size: 18px">{{$reserva->nombre}}</strong></p>
    <p style="color: darkgreen; font-size: 15px">Teléfono: <strong style="color: black; font-size: 18px">{{$reserva->telefono}}</strong></p>
    <p style="color: darkgreen; font-size: 15px">Horario: <strong style="color: black; font-size: 18px">{{$fecha->horario_apertura}}-{{$fecha->horario_cierre}}</strong></p>
    <p style="color: darkgreen; font-size: 15px">Comensales: <strong style="color: black; font-size: 18px">{{$reserva->comensales}}</strong></p>
    <p style="color: darkgreen; font-size: 15px">Alergenos: </p>
    <div style="margin-left: 3em">
        @foreach($alergenos as $alergeno)
            <p style="color: black; font-size: 18px">{{$alergeno->nombre}}</p>
        @endforeach
    </div>
</div>
<div style="padding: 3em">
    @if($fecha->menu)
        <h2>Menú para el día <strong>{{$fecha->fecha}}</strong></h2>
        <img src="/images/{{$fecha->menu}}" alt="{{$fecha->fecha}}" />
    @else
        <h2>Menú para el día <strong>{{$fecha->fecha}} sin definir</strong></h2>
        <p>Cuando esté el menú se le enviará un email</p>
    @endif
</div>
</body>
</html>
