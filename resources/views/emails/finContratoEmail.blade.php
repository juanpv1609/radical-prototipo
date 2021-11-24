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
table.blueTable td, table.blueTable th {
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
    <table class="blueTable">
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
                <td>Fecha de inicio:</td>
                <td><strong>{{ $details['fecha_inicio'] }}</strong></td>
            </tr>
            <tr>
                <td>Fecha de finalización:</td>
                <td><strong>{{ $details['fecha_fin'] }}</strong></td>
            </tr>
            <tr>
                    <td>Tiempo restante de servicio:</td>
                    <td ><strong style="color: rgb(11, 79, 204)">{{ $details['plazo_finalizacion']+1 }} días</strong></td>


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
