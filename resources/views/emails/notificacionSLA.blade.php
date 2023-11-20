<!DOCTYPE html>

<html>

<head>

    <title>Grupo radical</title>
    <style>
        @font-face {
            font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
        }

        table.blueTable {
            font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
            border: 3px solid #1C6EA4;
            background-color: #D0E4F5;
            width: 100%;
            text-align: left;
        }

        table.blueTable td,
        table.blueTable th {
            border: 1px solid #AAAAAA;
            padding: 3px 2px;
        }

        table.blueTable tbody td {
            font-size: 12px;
        }

        table.blueTable td:nth-child(even) {
            background: #FFFFFF;
        }

        table.blueTable tfoot td {
            font-size: 14px;
        }

        table.blueTable tfoot .links {
            text-align: right;
        }

        table.blueTable tfoot .links a {
            display: inline-block;
            background: #1C6EA4;
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>
                @if (($details['alerta'] == 'Alta' || $details['alerta'] == 'Critica'))
                <img src="https://1.bp.blogspot.com/--fIyUxZFUQI/YQGlgEIfFTI/AAAAAAAAon4/hTPJIIUNW64wNVfAZHFaO2owY4ZZ71ftACLcBGAsYHQ/s200/rojo.png" alt="">
                @else
                <img src="https://1.bp.blogspot.com/-5qO7ED_Phk0/YQGk89tHRdI/AAAAAAAAonw/rGKq4aik4KEgi5ydkHmJOn83EJeElULBgCLcBGAsYHQ/s200/amarilllo.png" alt="">
                @endif

            </td>

            <td>
                <h2 class="h2">{{ $details['title'] }}</h2>
            </td>
        </tr>
    </table>


    <p>{{ $details['body'] }}</p>
    <table class="blueTable">
        <tbody>
            <tr>
                <td style="font-size: 15px">Tiempo Restante:</td>
                <td style="font-size: 20px"><strong>{{ $details['message'] }}</strong></td>
            </tr>

            <tr>
                <td style="font-size: 15px">Cliente:</td>
                <td style="font-size: 20px"><strong> CNT Defensiva</strong></td>
            </tr>

            <tr>
                <td style="font-size: 15px">Código de la Incidencia:</td>
                <td style="font-size: 15px"><strong>{{ $details['code'] }}</strong></td>
            </tr>
            <tr>
                <td style="font-size: 15px">Estado de la Incidencia:</td>
                <td style="font-size: 15px"><strong>{{ $details['status'] }}</strong></td>
            </tr>
            <tr>
                <td style="font-size: 15px">Fecha de {{$details['typeDate']}}:</td>
                <td style="font-size: 15px"><strong>{{ $details['date'] }}</strong></td>
            </tr>
            <tr>
                <td style="font-size: 15px">Tipo de Incidencia:</td>
                <td style="font-size: 15px">{{ $details['category'] }}</td>
            </tr>
            <tr>
                <td style="font-size: 15px">Categoría:</td>
                <td style="font-size: 15px">{{ $details['type'] }}</td>
            </tr>
            <tr>
                <td style="font-size: 15px">Título de la Incidencia:</td>
                <td style="font-size: 15px">{{ $details['titleIncident'] }}</td>
            </tr>

            <tr>
                <td style="font-size: 15px">Descripción:</td>
                <td style="font-size: 15px">{{ $details['description'] }}</td>
            </tr>

        </tbody>
    </table>
    <br>
    <img src="https://1.bp.blogspot.com/-NS9JLHzt1vI/YLgAPd7JaKI/AAAAAAAAoFQ/cBQmkA3KQtUKYG2iFuTHsS4OmIGSBtNoQCLcBGAsYHQ/s0/socfirma.png" alt="logo">
    <br>
    <p><small style="font-size: 10px">Este correo fue generado automaticamente, por lo cual no debe responderlo.
            Si existe algún error comunicarse con <a>juan.perugachi@gruporadical.com</a></small></p>

</body>

</html>
