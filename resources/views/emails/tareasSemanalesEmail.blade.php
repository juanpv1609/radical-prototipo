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
  border: 2px solid #1C6EA4;
  background-color: #EEEEEE;
  width: 100%;
  text-align: left;
}
table.blueTable td, table.blueTable th {
  padding: 3px 2px;
}
table.blueTable tbody td {
  font-size: 12px;
}
table.blueTable tr:nth-child(even) {
  background: #D0E4F5;
}
table.blueTable thead {
  background: #1C6EA4;
  background: -moz-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: -webkit-linear-gradient(top, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  background: linear-gradient(to bottom, #5592bb 0%, #327cad 66%, #1C6EA4 100%);
  border-bottom: 2px solid #444444;
}
table.blueTable thead th {
  font-size: 14px;
  font-weight: bold;
  color: #FFFFFF;
  text-align: center;
}
table.blueTable tfoot td {
  font-size: 14px;
}
table.blueTable tfoot .links {
  text-align: right;
}
table.blueTable tfoot .links a{
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
                <img src="https://1.bp.blogspot.com/-5qO7ED_Phk0/YQGk89tHRdI/AAAAAAAAonw/rGKq4aik4KEgi5ydkHmJOn83EJeElULBgCLcBGAsYHQ/s200/amarilllo.png" alt="">


            </td>

            <td><h2 class="h2">{{ $details['title'] }}</h2></td>
        </tr>
    </table>


    <p>{{ $details['body'] }}</p>
    <table class="blueTable">
        <thead>
            <tr>
                <th>CLIENTE</th>
                <th>ENTREGABLE</th>
                <th>FECHA DE ENTREGA</th>
                {{-- <th>Plazo (días):</th> --}}
                <th>RESPONSABLE</th>
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
