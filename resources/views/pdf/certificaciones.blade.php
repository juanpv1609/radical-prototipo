<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        body {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: 9px;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .px-0 {
            padding-right: 0 !important;
            padding-left: 0 !important
        }

        .gray {
            background-color: lightgray
        }

        .text-center {
            text-align: center
        }

        .h4,
        h4 {
            font-size: 1rem
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .05)
        }

        .table-sm td,
        .table-sm th {
            padding: .3rem
        }

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
            content: "Pagina "counter(page);
        }

        .text-warning {
            color: #f0ad4e !important
        }

        .text-danger {
            color: #d9534f !important
        }

        .text-success {
            color: #5cb85c !important
        }

        .text-info {
            color: #5bc0de !important
        }

        .text-primary {
            color: #0275d8 !important
        }

    </style>
</head>

<body style="font-size: 11px;-webkit-text-size-adjust: none">
    <div class="px-0">
        <table width="100%" style=" font-size: 6px;">
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td>
                                    <div name="logo" style="vertical-align: bottom;">
                                        <img src="{{ base_path() }}/public/img/nuevologo-radical.png"
                                            style="margin-top: -25px" alt="logo">
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
                                <td>{{ isset(\auth()->user()->name) ? \auth()->user()->name : "DEMO" }}</td>
                            </tr>
                            <td>Total Personas:</td>
                            <td>{{ $dataCertificaciones[0]['total_personas'] }}</td>
            </tr>
            </tr>
            <td>Total Certificaciones:</td>
            <td>{{ count($dataCertificaciones) }}</td>
            </tr>

            </tbody>
        </table>
        </td>
        </tr>
        </table>

        <h4 class="text-center">
            REPORTE DE CERTIFICACIONES
        </h4>
        @if (count($dataCertificaciones) > 0)
            <table border="1">

                <tr>
                    @foreach ($dataCertificaciones as $item)
                        <th style="width: 10%">
                            <p style="font-size: 10px;text-align: center">
                                <strong style="font-size: 34px; " class="text-primary">{{ $item['total'] }}</strong>
                                <br>
                                {{ $item['certificacion'] }}
                            </p>
                        </th>
                    @endforeach
                </tr>
            </table>
            <br>


            <table class="table table-striped table-sm" width="100%">
                <thead>
                    <tr style="background: #aaa;color:#000">
                        <td><strong>Persona</strong></td>
                        <td><strong>Pais</strong></td>
                        <td><strong>Status</strong></td>
                    </tr>


                </thead>

                <tbody>
                    @foreach ($dataCertificaciones as $item)
                        @if ($item['total'] > 0)
                            <tr style="background: #0275d8;color:#FFF">
                                <th colspan="3">{{ $item['certificacion'] }}</th>
                            </tr>
                            @foreach ($item['personas'] as $person)
                                <tr>
                                    <td>{{ $person['nombre'] }}</td>
                                    <td>{{ $person['pais'] }}</td>
                                    <td style="color:{{ $person['estado_color'] }}">{{ $person['estado'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br>


        @else
            <p class="text-info">No se encontraron resultados </p>
        @endif
        <table class="table table-striped table-sm" width="100%">

            <tbody>

            </tbody>
        </table>

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
