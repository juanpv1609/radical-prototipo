<!DOCTYPE html>

<html>

<head>

    <title>Grupo radical</title>

</head>

<body>

    <h1 class="h1">{{ $details['title'] }}</h1>

    <p>{{ $details['body'] }}</p>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <td>Cliente:</td>
                <td><strong>{{ $details['cliente'] }}</strong></td>
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
    <img src="https://www.gruporadical.com/build/radical/nuevologo-radical.png" alt="logo">
    <br>
    <p><small style="font-size: 10px">Este correo fue generado automaticamente, por lo cual no debe responderlo.
        Si existe algún error, eliminarlo o comunicarse con <a >juan.perugachi@gruporadical.com</a></small></p>

</body>

</html>
