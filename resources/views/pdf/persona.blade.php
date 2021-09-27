
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
    body {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: 9px;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .px-0{padding-right:0!important;padding-left:0!important}
    .gray {
        background-color: lightgray
    }
    .text-center{
        text-align: center
    }
    .h4,h4{
        font-size: 1rem
    }

    .table-striped tbody tr:nth-of-type(odd){background-color:rgba(0,0,0,.05)}
    .table-sm td,.table-sm th{padding:.3rem}
    #header,
    #footer {
    position: fixed;
    left: 0;
        right: 0;
        color: #aaa;
        font-size: 0.9em;
    }
    #header {
    top: 0;
        border-bottom: 0.1pt solid #aaa;
    }
    #footer {
    bottom: 0;
    border-top: 0.1pt solid #aaa;
    }
    .page-number:before {
    content: "Pagina " counter(page);
    }
    .text-warning{color:#f0ad4e!important}
    .text-danger{color:#d9534f!important}
    .text-success{color:#5cb85c!important}
    .text-info{color:#5bc0de!important}
    .text-primary{color:#0275d8!important}
</style>
</head>
<body style="font-size: 11px;-webkit-text-size-adjust: none">
    <div class="px-0">
        <table width="100%" style=" font-size: 6px;">
            <tr>
                <td>
                    <table >
                        <tbody>
                            <tr>
                                <td>
                                    <div name="logo" style="vertical-align: bottom;">
                                        <img src="{{ base_path() }}/public/img/nuevologo-radical.png" style="margin-top: -25px" alt="logo">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="vertical-align: bottom;text-align: right;margin-top: -25px">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td>Fecha de emisión:</td>
                                <td>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td>Emitido por:</td>
                                <td>{{ isset(\auth()->user()->name) ? \auth()->user()->name : "DEMO"}}</td>
                            </tr>
                             <tr>
                                <td>Total estudios:</td>
                                <td>{{count($estudios)}}</td>
                            </tr>
                            <tr>
                                <td>Total certificaciones:</td>
                                <td>{{count($certificaciones)}}</td>
                            </tr>
                           {{-- <tr>
                                <td>Total:</td>
                                <td>{{$contratos->total_iniciados + $contratos->total_terminados}}</td>
                            </tr> --}}

                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <h4 class="text-center">
            {{ $persona->nombre }} {{ $persona->apellido }}
        </h4>
        <h3>Información Personal</h3>

        <table border="1" width="100%">

            <tbody>
                <tr>
                    <td style="width: 10%">
                            <img src="data:image/png;base64,{{ $persona->foto }}"  alt="logo">

                    </td>
                    <td> <table>
                            <tr><td ><strong>CI:</strong></td>
                                <td >{{ $persona->ci }}</td></tr>
                            <tr><td ><strong>EMAIL:</strong></td>
                                <td >{{ $persona->email }}</td></tr>
                                <tr><td ><strong>TELEFONO:</strong></td>
                                    <td >{{ $persona->telefono }}</td></tr>
                            <tr><td><strong>FECHA NAC:</strong></td>
                                <td>{{ $persona->fecha_nacimiento }}</td>
                            </tr>
                            <tr><td><strong>NACIONALIDAD:</strong></td>
                                <td>{{ $persona->nacionalidad->nombre }}</td>
                            </tr>
                            <tr><td><strong>PAIS DE RESIDENCIA:</strong></td>
                                <td>{{ $persona->pais->nombre }}</td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <h3>Estudios Realizados</h3>
        @if (count($estudios)>0)
        <table class="table table-striped table-sm" width="100%">
            <thead style="background: #0275d8;color:#FFF">
                <tr>
                    <td><strong>INSTITUCION</strong></td>
                    <td><strong>DESCRIPCION</strong></td>
                    <td ><strong>NIVEL</strong></td>
                    <td ><strong>INICIO</strong></td>
                    <td ><strong>FIN</strong></td>
                    <td ><strong>CERTIFICACION</strong></td>
                    <td><strong>ESTADO</strong></td>
                </tr>

            </thead>
            <tbody>
                @foreach ($estudios as $item)

                <tr>
                    <td>{{ $item['institucion'] }}</td>
                    <td>{{ $item['descripcion'] }}</td>
                    <td >{{ $item['nivel'] }}</td>
                    <td >{{ $item['inicio'] }}</td>
                    <td >{{ $item['fin'] }}</td>

                    <td >{{ ($item['certificado']!==null) ? 'SI' : 'NO' }}</td>
                    <td style="color:{{ $item['estado_color'] }}">{{ $item['estado'] }}</td>
                </tr>
                @endforeach


            </tbody>
        </table>
        @else
         <p class="text-info">No se encontraron resultados </p>
        @endif
        <br>
        <h3>Certificaciones</h3>
        @if (count($certificaciones)>0)
        <table class="table table-striped table-sm" width="100%">
            <thead style="background: #0275d8;color:#FFF">
                <tr>
                    <td><strong>CERTIFICACION</strong></td>
                    <td><strong>INSTITUCION</strong></td>
                    <td><strong>DESCRIPCION</strong></td>
                </tr>

            </thead>
            <tbody>
                @foreach ($certificaciones as $item)

                <tr>
                    <td>{{ $item['solucion'] }}</td>
                    <td>{{ $item['institucion'] }}</td>
                    <td>{{ $item['descripcion'] }}</td>

                </tr>
                @endforeach


            </tbody>
        </table>
        @else
         <p class="text-info">No se encontraron resultados </p>
        @endif

    </div>
<script type="text/php">
    if (isset($pdf)) {
        $text = "Pagina {PAGE_NUM} de {PAGE_COUNT}";
        $size = 8;
        $font = $fontMetrics->getFont("Verdana");
        $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
        $x = ($pdf->get_width() - $width) / 2;
        $y = $pdf->get_height() - 35;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>
</body>
