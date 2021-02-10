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
                <td>Fecha inicial</td>
                <td>{{ $details['fecha_inicio'] }}</td>
            </tr>
            <tr>
                <td>Fecha final</td>
                <td>{{ $details['fecha_fin'] }}</td>
            </tr>
            <tr>
                <td>Area</td>
                <td>{{ $details['area'] }}</td>
            </tr>
            <tr>
                <td>Solucion</td>
                <td>{{ $details['solucion'] }}</td>
            </tr>
        </tbody>
    </table>


    <p>Thank you</p>

</body>

</html>
