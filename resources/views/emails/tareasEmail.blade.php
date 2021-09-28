<!DOCTYPE html>

<html>

<head>

    <title>Grupo radical</title>
<style>
    @font-face {
            font-family: "source_sans_proregular";
            src: local("Source Sans Pro"), url("fonts/sourcesans/sourcesanspro-regular-webfont.ttf") format("truetype");
            font-weight: normal;
            font-style: normal;

        }
</style>
</head>

<body>
    <table>
        <tr>
            <td>
                @if ($details['alerta']==1)
                <img src="https://1.bp.blogspot.com/-5qO7ED_Phk0/YQGk89tHRdI/AAAAAAAAonw/rGKq4aik4KEgi5ydkHmJOn83EJeElULBgCLcBGAsYHQ/s200/amarilllo.png" alt="">
                @else
                <img src="https://1.bp.blogspot.com/--fIyUxZFUQI/YQGlgEIfFTI/AAAAAAAAon4/hTPJIIUNW64wNVfAZHFaO2owY4ZZ71ftACLcBGAsYHQ/s200/rojo.png" alt="">
                @endif

            </td>

            <td><h2 class="h2">{{ $details['title'] }}</h2></td>
        </tr>
    </table>


    <p>{{ $details['body'] }}</p>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <td>Cliente:</td>
                <td style="font-size: 20px"><strong>{{ $details['cliente'] }}</strong></td>
            </tr>
            <tr>
                <td>Descripción del contrato:</td>
                <td>{{ $details['descripcion_contrato'] }} / {{ $details['observacion_contrato'] }}</td>
            </tr>
            <tr>
                <td>Fecha de alerta:</td>
                <td><strong>{{ $details['fecha_alerta'] }}</strong></td>
            </tr>
            <tr>
                <td>Fecha de entrega:</td>
                <td><strong>{{ $details['fecha_entrega'] }}</strong></td>
            </tr>
            <tr>
                @if ($details['plazo_entrega'] >= 0)
                    <td>Se entrega en:</td>
                    <td ><strong style="color: rgb(11, 79, 204)">{{ $details['plazo_entrega']+1 }} día/s</strong></td>
                @else
                    <td>Retrasado por:</td>
                    <td ><strong style="color: #D32F2F">{{ abs($details['plazo_entrega']) }} día/s</strong></td>
                @endif

            </tr>
            <tr>
                <td>Tarea:</td>
                <td>{{ $details['tipo_tarea'] }}</td>
            </tr>
            <tr>
                <td>Entregable:</td>
                <td style="font-size: 20px"><strong>{{ $details['entregable'] }}</strong></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <img src="https://1.bp.blogspot.com/-NS9JLHzt1vI/YLgAPd7JaKI/AAAAAAAAoFQ/cBQmkA3KQtUKYG2iFuTHsS4OmIGSBtNoQCLcBGAsYHQ/s0/socfirma.png" alt="logo">
    <br>
    <p><small style="font-size: 10px">Este correo fue generado automaticamente, por lo cual no debe responderlo.
        Si existe algún error comunicarse con <a >juan.perugachi@gruporadical.com</a></small></p>

</body>

</html>
