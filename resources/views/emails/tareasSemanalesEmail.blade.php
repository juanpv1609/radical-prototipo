<!DOCTYPE html>

<html>

<head>

    <title>Grupo radical</title>
<style>
    @font-face {
        font-family: 'Helvetica';
        font-weight: normal;
        font-style: normal;
        font-variant: normal;
        src: url("font url");
      }
      body {
        font-family: Helvetica, sans-serif;
      }
</style>
</head>

<body>
    <table>
        <tr>
            <td>
                <img src="https://1.bp.blogspot.com/-5qO7ED_Phk0/YQGk89tHRdI/AAAAAAAAonw/rGKq4aik4KEgi5ydkHmJOn83EJeElULBgCLcBGAsYHQ/s200/amarilllo.png" alt="">


            </td>

            <td><h2 class="h2">{{ $details['title'] }}</h2></td>
        </tr>
    </table>


    <p>{{ $details['body'] }}</p>
    <table width="100%" border="1">
        <thead>
            <tr>
                <th>CLIENTE:</th>
                <th>ENTREGABLE:</th>
                <th>FECHA DE ENTREGA:</th>
                {{-- <th>Plazo (días):</th> --}}
                <th>RESPONSABLE:</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details['alertas'] as $alerta)
                <tr>
                    <td> {{ $alerta->contrato->cliente->nombre_comercial }} </td>
                    <td> {{ $alerta->descripcion }} </td>
                    <td> {{ $alerta->fecha }} </td>
                    {{-- <td> {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($alerta->fecha),false)}} </td> --}}
                    <td> {{ $alerta->usuario->name }} </td>

                </tr>
            @endforeach

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
