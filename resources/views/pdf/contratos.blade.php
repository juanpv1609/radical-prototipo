
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
                                <td>{{\auth()->user()->name}}</td>
                            </tr>
                            <tr>
                                <td>Total iniciados:</td>
                                <td>{{$contratos->total_iniciados}}</td>
                            </tr>
                            <tr>
                                <td>Total terminados:</td>
                                <td>{{$contratos->total_terminados}}</td>
                            </tr>
                            <tr>
                                <td>Total:</td>
                                <td>{{$contratos->total_iniciados + $contratos->total_terminados}}</td>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
        </table>

        <h4 class="text-center">
            REPORTE DE CONTRATOS REGISTRADOS
        </h4>
        @if (count($contratos)>0)
        <table class="table table-striped table-sm" width="100%">
            <thead>
                <tr>
                    <th>CLIENTE</th>
                    <th>DESCRIPCION</th>
                    <th style="width: 10%">FECHA INICIO</th>
                    <th style="width: 10%">FECHA FIN</th>
                    <th>AREA</th>
                    <th>ESTADO</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($contratos as $item)
                    <tr>
                        <td>{{ $item->cliente->razon_social }}</td>
                        <td>{{ $item->observacion }}</td>
                        <td>{{ $item->fecha_inicio }}</td>
                        <td>{{ $item->fecha_fin }}</td>
                        <td>{{ $item->area->nombre }}</td>
                        <td class="text-center">

                            @if($item->estado==1)
                            <strong class="text-info">
                                Iniciado
                            </strong>
                            @else
                            <strong class="text-success">
                                Terminado
                            </strong>
                            @endif

                        </td>
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
