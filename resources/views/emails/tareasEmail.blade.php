<!DOCTYPE html>

<html>

<head>

    <title>Grupo radical</title>

</head>

<body>

    <h1>{{ $details['title'] }}</h1>

    <p>{{ $details['body'] }}</p>
    <table width="50%">
        <tbody>
            <tr>
                <td>Cliente</td>
                <td>{{ $details['cliente'] }}</td>
            </tr>
            <tr>
                <td>Fecha entrega</td>
                <td>{{ $details['fecha_entrega'] }}</td>
            </tr>
            <tr>
                <td>Tarea</td>
                <td>{{ $details['tipo_tarea'] }}</td>
            </tr>
        </tbody>
    </table>



</body>

</html>
