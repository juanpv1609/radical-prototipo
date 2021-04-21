<template>
<div>
    <v-card elevation="2" :loading="loading">
        <v-card-title class="d-flex justify-space-between"
            >Creación de Tareas
            <v-spacer></v-spacer>

        </v-card-title>

        <v-card-text>
            <v-row>
                <v-col cols="8">
                    <v-row>
                        <v-col cols="6">

                            <v-autocomplete
                                    :items="usuarios"
                                    item-text="name"
                                    item-value="id"
                                    v-model="usuario"
                                    label="Seleccione un responsable"
                                    return-object
                                    dense
                                ></v-autocomplete>
                        </v-col>
                        <v-col cols="6">

                            <v-autocomplete
                                    :items="tipo_tareas"
                                    item-text="nombre"
                                    item-value="id"
                                    v-model="tipo_tarea"
                                    label="Seleccione un tipo de tarea"
                                    return-object
                                    dense
                                ></v-autocomplete>
                        </v-col>
                    </v-row>
                     <v-row>
                        <v-col cols="6">

                            <v-autocomplete
                                    :items="frecuencias"
                                    item-text="descripcion"
                                    item-value="id"
                                    v-model="frecuencia"
                                    label="Frecuencia"
                                    return-object
                                    dense
                                ></v-autocomplete>
                        </v-col>
                        <v-col cols="6">

                            <v-autocomplete
                                    :items="dias"
                                    item-text="text"
                                    item-value="id"
                                    v-model="dia"
                                    label="Cada dia"
                                    return-object
                                    dense
                                ></v-autocomplete>
                        </v-col>


                    </v-row>
                    <v-row>
                            <v-col cols="12">
                                <v-btn
                                    color="primary"
                                    @click="generarFechas"
                                    >
                                    Generar Tareas
                                    </v-btn>
                            </v-col>
                        </v-row>

                </v-col>
                <v-col cols="4">
                    <table class="table table-sm table-borderless">
                            <thead class="table-dark">
                                <tr>
                                    <th colspan="2">Detalles del contrato</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                                <tr>
                                    <td>Cliente</td>
                                    <td>{{contrato.cliente.nombre_comercial}}</td>
                                </tr>
                                <tr>
                                    <td>Fecha inicial</td>
                                    <td><span class="text-success">{{contrato.fecha_inicio}}</span></td>
                                </tr>
                                <tr>
                                    <td>Fecha final</td>
                                    <td><span class="text-danger">{{contrato.fecha_fin}}</span></td>
                                </tr>
                            </tbody>

                        </table>
                        <v-btn
                        color="success"
                        block
                        :loading="loading"
                        :disabled="(loading || !tareas.length>0)"
                        @click="addTarea"
                        >
                        Enviar {{(parseInt(diferencia)>0) ? parseInt(diferencia) : '' }} tareas
                        </v-btn>

                </v-col>
            </v-row>
            <v-row>
                        <v-col cols="12" v-if="tareas.length>0">
                            <v-simple-table  fixed-header height="500px">
                                <template v-slot:default>
                                    <thead >
                                        <tr>
                                                <th style="width:18%">Responsable</th>
                                                <th style="width:15%">Tarea</th>
                                                <th >Entregable</th>
                                                <th style="width:15%">Fecha</th>
                                                <th style="width:5%">
                                                    <input
                                                            type="text"
                                                            class="form-control form-control-sm"
                                                            v-model="alerta"
                                                            @keyup.enter="cambiaAlertas"
                                                        />
                                                        Alerta

                                                </th>
                                                <th></th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                        v-for="value in tareas"
                                        :key="value.id"
                                        >
                                        <td>
                                                        <select
                                                                v-model="value.responsable"
                                                                class="form-control form-control-sm"
                                                            >
                                                                <option
                                                                    v-for="item in usuarios"
                                                                    v-bind:key="item.id"
                                                                    v-bind:value="item.id"
                                                                >
                                                                    {{ item.name }}
                                                                </option>
                                                            </select>
                                                    </td>
                                                    <td>
                                                        <select
                                                                v-model="value.tipo_tarea"
                                                                class="form-control form-control-sm"
                                                            >
                                                                <option
                                                                    v-for="item in tipo_tareas"
                                                                    v-bind:key="item.id"
                                                                    v-bind:value="item.id"
                                                                >
                                                                    {{ item.nombre }}
                                                                </option>
                                                            </select>
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control form-control-sm"
                                                         v-model="value.descripcion"
                                                         rows="1">
                                                         </textarea>
                                                    </td>
                                                    <td>
                                                        <input
                                                            type="date"
                                                            class="form-control form-control-sm"
                                                            v-model="value.fecha"
                                                        />
                                                    </td>
                                                    <td>
                                                        <input
                                                            type="text"
                                                            class="form-control form-control-sm"
                                                            v-model="value.alerta"
                                                        />
                                                    </td>
                                                    <th>
                                                        <v-btn  icon color="red" @click="deleteTarea(value.id)">
                                                            <v-icon dark>mdi-delete</v-icon>
                                                            </v-btn>
                                                    </th>
                                        </tr>
                                    </tbody>
                                    </template>
                            </v-simple-table>
                        </v-col>
                    </v-row>
        </v-card-text>
    </v-card>
</div>



</template>
<script>
import moment from "moment";

export default {
    data() {
        return {
            alerta:null,
            contrato: {},
            frecuencias: {},
            usuarios: [],
            tareas: {},
            tarea: [],
            request: {},
            diferencia:0,
            tipo_tareas: [],
            datos: [],
            loading: false,
            usuario:{},
            tipo_tarea:{},
            frecuencia:{},
            dia:{},
            dias: [
                { text: "LUNES", value: 1 },
                { text: "MARTES", value: 2 },
                { text: "MIERCOLES", value: 3 },
                { text: "JUEVES", value: 4 },
                { text: "VIERNES", value: 5 },
                { text: "SABADO", value: 6 },
                { text: "DOMINGO", value: 7 }
            ],

            headersTareas: [
                { text: "Responsable", value: "responsable" },
                { text: "Tipo", value: "tipo_tarea" },
                { text: "Fecha", value: "fecha" },
                { text: "Alerta", value: "alerta" },
                { text: "", value: "controls", sortable: false  },
            ],

        };
    },
    created() {

        this.initialData();
        //console.log(moment().format('MMMM Do YYYY, h:mm:ss a'));
    },
    methods: {
        cambiaAlertas(){
            this.tareas.forEach(element => {
                element.alerta=this.alerta
            });
        },
        initialData(){
            this.axios
            .get("/api/frecuencias/")
            .then(response => {
                this.frecuencias = response.data;
                console.log(this.frecuencias);
            });
            this.axios
            .get("/api/usuarios/")
            .then(response => {
                this.usuarios = response.data;
            });
            this.axios
            .get("/api/tipo-tareas/")
            .then(response => {
                this.tipo_tareas = response.data;
            });
            this.axios
            .get(`/api/contratos/${this.$route.params.id}`)
            .then((res) => {
                this.contrato = res.data;

            });

        },
        addTarea() {
            this.loading=true;

            console.log(JSON.stringify(this.tareas));
            this.request.tareas=this.tareas;
            this.$swal.fire({
                        title: 'Espere',
                        text: 'Creando tareas...',
                        icon: 'info',
                        allowOutsideClick: false
                    });
            this.$swal.showLoading();
            this.axios
                    .post('/api/tareas', this.request)
                    .then(() => {
                        this.$swal.fire({
                                title: 'Correcto',
                                text: 'Tareas creadas correctamente!',
                                icon: 'success',
                                timer: 1500,
                                timerProgressBar: true,
                                });
                         this.loading=false;



                    })
                    .catch(err => console.log(err))
                    .finally(() => {
                        //this.initialData();
                        this.tareas = {};
                        this.tarea = [];
                        this.request = {};
                        this.diferencia=0;
                    })
        },
        /* pushTarea(tarea) {
            console.log(tarea);
            this.datos.push({
                id: this.diferencia+1,
                contrato_id: this.contrato.id,
                dia_elegido: this.dias.value,
                fecha: moment(tarea.fecha).format( "YYYY-MM-DD"),
                responsable: tarea.responsable,
                tipo_tarea: tarea.tipo_tarea,
                frecuencia: this.frecuencias.value.id,
                alerta: tarea.alerta
            });

            this.diferencia++;
        }, */
        deleteTarea(id) {
            let i = this.tareas.map(data => data.id).indexOf(id);
            this.tareas.splice(i, 1);
            this.diferencia--;
        },
        generarFechas() {
            moment.locale('es');
            this.datos  = [];
            let fecha_inicio = moment(this.contrato.fecha_inicio);
            let fecha_fin = moment(this.contrato.fecha_fin);
            let frecuencia = this.frecuencia.id;
            if (!this.dia.value) {
                this.dia.value=1
            }
            let num_dia = this.dia.value;

            let dia_preferido;
            let alerta=this.frecuencia.alerta;
            switch (frecuencia) {
                case 2: //semanal
                //this.algoritmo(fecha_inicio,fecha_fin,frecuencia,alerta,num_dia,"week","weeks",1);
                    //alerta=2;
                     this.diferencia = parseInt(fecha_fin.diff(fecha_inicio, "weeks")) + parseInt(1);
                    for (let i = 1; i < parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("week");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                id: i,
                                descripcion: ('INFORME '+this.frecuencia.descripcion+' '+moment(dia_preferido).format( "MMM-YYYY")).toUpperCase(),
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dia.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuario.id,
                                tipo_tarea: this.tipo_tarea.id,
                                frecuencia: frecuencia,
                                alerta: alerta
                            });
                            fecha_inicio.add(1, "weeks");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }

                    break;
                case 3: //mensual
                   // this.algoritmo(fecha_inicio,fecha_fin,frecuencia,alerta,num_dia,"month","months",1);

                   //  alerta=5;

                    this.diferencia = parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1);
                    for (let i = 1; i <= parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            var aux_fecha= moment(dia_preferido);
                            this.datos.push({
                                id: i,
                                descripcion: (`INFORME ${this.frecuencia.descripcion} ${moment(dia_preferido).format( "YYYY")} ${moment(aux_fecha.subtract(1,"months")).format( "MMMM")}-${moment(dia_preferido).format( "MMMM")}`).toUpperCase(),
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dia.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuario.id,
                                tipo_tarea: this.tipo_tarea.id,
                                frecuencia: frecuencia,
                                alerta: alerta
                            });
                            fecha_inicio.add(1, "months");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }
                    break;
                case 4: //trimestral
                    //this.algoritmo(fecha_inicio,fecha_fin,frecuencia,alerta,num_dia,'month','months',3);

                    this.diferencia = (parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1))/3;
                    for (let i = 1; i <= parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                               id: i,
                                descripcion: ('INFORME '+this.frecuencia.descripcion+' '+moment(dia_preferido).format( "YYYY")+' ('+i+'/'+parseInt(this.diferencia)+')').toUpperCase(),
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dia.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuario.id,
                                tipo_tarea: this.tipo_tarea.id,
                                frecuencia: frecuencia,
                                alerta: alerta
                            });
                            fecha_inicio.add(3, "months");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }

                    break;
                case 5: //semestral
                    //this.algoritmo(fecha_inicio,fecha_fin,frecuencia,alerta,num_dia,"month","months",6);

                    this.diferencia = (parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1))/6;
                    for (let i = 1; i <= parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                id: i,
                                descripcion: ('INFORME '+this.frecuencia.descripcion+' '+moment(dia_preferido).format( "YYYY")+' ('+i+'/'+parseInt(this.diferencia)+')').toUpperCase(),
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dia.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuario.id,
                                tipo_tarea: this.tipo_tarea.id,
                                frecuencia: frecuencia,
                                alerta: alerta
                            });
                            fecha_inicio.add(6, "months");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }

                    break;
                default:
                    //anual
                    this.diferencia = (parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1))/12;
                    for (let i = 1; i <= parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                id: i,
                                descripcion: ('INFORME '+this.frecuencia.descripcion+' '+moment(dia_preferido).format( "YYYY")+' ('+i+'/'+parseInt(this.diferencia)+')').toUpperCase(),
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dia.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuario.id,
                                tipo_tarea: this.tipo_tarea.id,
                                frecuencia: frecuencia,
                                alerta: alerta
                            });
                            fecha_inicio.add(6, "months");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }

                    break;
            }

           // console.log("tareas:" + diferencia);

            this.tareas = this.datos;
            //console.log(JSON.stringify(this.mantenimientos));
            this.$toasted.success('Tareas generadas correctamente');
        },
        algoritmo(fecha_inicio,fecha_fin,frecuencia,alerta,num_dia,periodo,periodo_plural,divisor){
            let dia_preferido;
            console.log(fecha_inicio,fecha_fin,frecuencia,alerta,num_dia,periodo,periodo_plural,divisor);
            this.datos  = [];
            this.diferencia = (parseInt(fecha_fin.diff(fecha_inicio, periodo_plural.toString())) + parseInt(1))/divisor;
                    for (let i = 1; i < parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf(periodo.toString());
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                id: i,
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dias.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuarios.value.id,
                                tipo_tarea: this.tipo_tareas.value.id,
                                frecuencia: frecuencia,
                                alerta: alerta
                            });
                            fecha_inicio.add(1, "weeks");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }
        }
    }
};
</script>
