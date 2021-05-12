<!DOCTYPE html>

<html>

<head>

    <title>Grupo radical</title>

</head>

<body>
    <table>
        <tr>
            <td>
                @if ($details['alerta']==1)
                <svg width="120" height="60" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
           <path style="fill:#495A79;" d="M501.461,383.799L320.501,51.401C306.7,28.6,282.7,14.8,256,14.8s-50.7,13.8-64.501,36.601
               L10.539,383.799C-3.259,407.501-3.56,435.701,9.941,459.4c13.499,23.699,37.798,37.8,65.099,37.8h361.92
               c27.301,0,51.601-14.101,65.099-37.8C515.56,435.701,515.259,407.501,501.461,383.799z"/>
           <path style="fill:#42516D;" d="M502.059,459.4c-13.499,23.699-37.798,37.8-65.099,37.8H256V14.8c26.7,0,50.7,13.801,64.501,36.601
               L501.461,383.8C515.259,407.501,515.56,435.701,502.059,459.4z"/>
           <path style="fill:#FFDE33;" d="M475.661,399.1L294.699,66.699C286.601,52.9,271.901,44.8,256,44.8s-30.601,8.101-38.699,21.899
               L36.339,399.1c-8.399,14.101-8.399,31.199-0.298,45.3c8.099,14.399,22.798,22.8,39,22.8h361.92c16.201,0,30.901-8.401,39-22.8
               C484.06,430.299,484.06,413.201,475.661,399.1z"/>
           <path style="fill:#FFBC33;" d="M475.96,444.4c-8.099,14.399-22.798,22.8-39,22.8H256V44.8c15.901,0,30.601,8.101,38.699,21.899
               L475.661,399.1C484.06,413.201,484.06,430.299,475.96,444.4z"/>
           <g>
               <path style="fill:#495A79;" d="M256,437.2c-16.538,0-30-13.462-30-30s13.462-30,30-30s30,13.462,30,30S272.538,437.2,256,437.2z"/>
               <path style="fill:#495A79;" d="M286,317.2c0,16.538-13.462,30-30,30s-30-13.462-30-30v-150c0-16.538,13.462-30,30-30
                   s30,13.462,30,30V317.2z"/>
           </g>
           <g>
               <path style="fill:#42516D;" d="M286,407.2c0-16.538-13.462-30-30-30v60C272.538,437.2,286,423.738,286,407.2z"/>
               <path style="fill:#42516D;" d="M286,317.2v-150c0-16.538-13.462-30-30-30v210C272.538,347.2,286,333.738,286,317.2z"/>
           </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
           </svg>
                @else
                <svg width="120" height="60" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
           <path style="fill:#495A79;" d="M501.461,383.799L320.501,51.401C306.7,28.6,282.7,14.8,256,14.8s-50.7,13.8-64.501,36.601
               L10.539,383.799C-3.259,407.501-3.56,435.701,9.941,459.4c13.499,23.699,37.798,37.8,65.099,37.8h361.92
               c27.301,0,51.601-14.101,65.099-37.8C515.56,435.701,515.259,407.501,501.461,383.799z"/>
           <path style="fill:#42516D;" d="M502.059,459.4c-13.499,23.699-37.798,37.8-65.099,37.8H256V14.8c26.7,0,50.7,13.801,64.501,36.601
               L501.461,383.8C515.259,407.501,515.56,435.701,502.059,459.4z"/>
           <path style="fill:#EF5350;" d="M475.661,399.1L294.699,66.699C286.601,52.9,271.901,44.8,256,44.8s-30.601,8.101-38.699,21.899
               L36.339,399.1c-8.399,14.101-8.399,31.199-0.298,45.3c8.099,14.399,22.798,22.8,39,22.8h361.92c16.201,0,30.901-8.401,39-22.8
               C484.06,430.299,484.06,413.201,475.661,399.1z"/>
           <path style="fill:#D32F2F;" d="M475.96,444.4c-8.099,14.399-22.798,22.8-39,22.8H256V44.8c15.901,0,30.601,8.101,38.699,21.899
               L475.661,399.1C484.06,413.201,484.06,430.299,475.96,444.4z"/>
           <g>
               <path style="fill:#495A79;" d="M256,437.2c-16.538,0-30-13.462-30-30s13.462-30,30-30s30,13.462,30,30S272.538,437.2,256,437.2z"/>
               <path style="fill:#495A79;" d="M286,317.2c0,16.538-13.462,30-30,30s-30-13.462-30-30v-150c0-16.538,13.462-30,30-30
                   s30,13.462,30,30V317.2z"/>
           </g>
           <g>
               <path style="fill:#42516D;" d="M286,407.2c0-16.538-13.462-30-30-30v60C272.538,437.2,286,423.738,286,407.2z"/>
               <path style="fill:#42516D;" d="M286,317.2v-150c0-16.538-13.462-30-30-30v210C272.538,347.2,286,333.738,286,317.2z"/>
           </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
           </svg>
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
    <img src="https://www.gruporadical.com/build/radical/nuevologo-radical.png" alt="logo">
    <br>
    <p><small style="font-size: 10px">Este correo fue generado automaticamente, por lo cual no debe responderlo.
        Si existe algún error comunicarse con <a >juan.perugachi@gruporadical.com</a></small></p>

</body>

</html>
