<!DOCTYPE html>

<html>

<head>

    <title>Grupo radical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

</head>

<body>

    <h1 class="h1">{{ $details['title'] }}</h1>

    <p>{{ $details['body'] }}</p>
    <table width="80%" class="table table-striped">
        <tbody>
            <tr>
                <td>Cliente:</td>
                <td>{{ $details['cliente'] }}</td>
            </tr>
            <tr>
                <td>Descripción del contrato:</td>
                <td>{{ $details['descripcion_contrato'] }} / {{ $details['observacion_contrato'] }}</td>
            </tr>
            <tr>
                <td>Fecha de alerta:</td>
                <td>{{ $details['fecha_alerta'] }}</td>
            </tr>
            <tr>
                <td>Fecha de entrega:</td>
                <td>{{ $details['fecha_entrega'] }}</td>
            </tr>
            <tr>
                <td>Tarea:</td>
                <td>{{ $details['tipo_tarea'] }}</td>
            </tr>
            <tr>
                <td>Entregable:</td>
                <td>{{ $details['entregable'] }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <p><small>Este correo fue generado automaticamente, por lo cual no debe responderlo.
        Si existe algun error, eliminarlo o comunicarse con <a href="#">info@gruporadical.com</a> ó <a href="#">soporte@gruporadical.com</a></small></p>
    <br>
    <img src="{{ asset('img/nuevologo-radical.png') }}" alt="logo">

</body>

</html>
