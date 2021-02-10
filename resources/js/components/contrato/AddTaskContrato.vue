<template>
<div>
    <v-card elevation="2" :loading="loading">
        <v-card-title class="d-flex justify-space-between mb-6"
            >Clientes
            <v-btn
                class="mx-2"
                fab
                dark
                small
                color="primary"
                @click="addClient"
            >
                <v-icon dark>
                    mdi-plus
                </v-icon>
            </v-btn>
        </v-card-title>

        <v-card-text>
            <v-row>
                <v-col cols="8">
                    <v-row>
                        <v-col cols="6">

                        </v-col>
                        <v-col cols="6">

                        </v-col>
                    </v-row>
                     <v-row>
                        <v-col cols="6">

                        </v-col>
                        <v-col cols="6">

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
                                <td>Contrato N</td>
                                <td>{{contrato.id}}</td>
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
                                <tr>
                                    <td>Pais</td>
                                    <td>{{contrato.pais.nombre}}</td>
                                </tr>
                                <tr>
                                    <td>Area</td>
                                    <td>{{contrato.area.nombre}}</td>
                                </tr>
                                <tr>
                                    <td>Solucion</td>
                                    <td>{{contrato.solucion}}</td>
                                </tr>
                                <tr>
                                    <td>Marca</td>
                                    <td>{{contrato.marca}}</td>
                                </tr>
                            </tbody>

                        </table>
                        <button type="submit" class="btn btn-primary" :disabled="!tareas.length>0" >Enviar {{parseInt(diferencia)}} tareas</button>
                   
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</div>
<div>

<form @submit.prevent="addTarea">
        <div class="card ">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Creacion de Tareas</h5>
                <router-link
                    to="/contratos"
                    class="btn btn-primary btn-sm"
                    >Regresar</router-link
                >
            </div>
            <div class="card-body h-75">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="tarea" class="form-label"
                                        >Responsable:</label
                                    >
                                    <select
                                        v-model="usuarios.value"
                                        class="form-control"
                                    >
                                        <option
                                            v-for="item in usuarios"
                                            v-bind:key="item.id"
                                            v-bind:value="item.id"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="tarea" class="form-label"
                                        >Tipo de tarea:</label
                                    >
                                    <select
                                        v-model="tipo_tareas.value"
                                        class="form-control"
                                    >
                                        <option
                                            v-for="tipo in tipo_tareas"
                                            v-bind:key="tipo.id"
                                            v-bind:value="tipo.id"
                                        >
                                            {{ tipo.nombre }}
                                        </option>
                                    </select>
                                </div>
                        </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="frecuencia" class="form-label"
                                        >Frecuencia:</label
                                    >
                                    <select
                                        v-model="frecuencias.value"
                                        class="form-control"
                                    >
                                        <option
                                            v-for="item in frecuencias"
                                            v-bind:key="item.id"
                                            v-bind:value="item.id"
                                        >
                                            {{ item.descripcion }}
                                        </option>
                                    </select>
                                </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="dias" class="form-label"
                                    >Cada dia:</label
                                >
                            <div class="input-group mb-3">

                                <select v-model="dias.value" class="form-control">
                                    <option
                                        v-for="item in dias"
                                        v-bind:key="item.value"
                                        v-bind:value="item.value"
                                    >
                                        {{ item.text }}
                                    </option>
                                </select>
                                <button
                                v-on:click="generarFechas"
                                type="button"
                                class="btn btn-warning"
                            >
                                Generar Tareas
                            </button>
                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive overflow-auto " v-bind:style="{heigth:'50%'}" v-if="tareas.length>0">
                                    <table class="table table-sm">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Responsable</th>
                                                <th>Tipo</th>
                                                <th style="width:20%">Fecha</th>
                                                <th style="width:10%">Alerta</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                <tr
                                                    v-for="value in tareas"
                                                    v-bind:key="value.id"
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
                                                                class="form-control form-control-sm" disabled
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
                                                        <button
                                                            class="btn btn-sm btn-danger"
                                                            type="button"
                                                            v-on:click="deleteTarea(value.id)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <table class="table table-sm table-borderless">
                            <thead class="table-dark">
                                <tr>
                                    <th colspan="2">Detalles del contrato</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <td>Contrato N</td>
                                <td>{{contrato.id}}</td>
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
                                <tr>
                                    <td>Pais</td>
                                    <td>{{contrato.pais.nombre}}</td>
                                </tr>
                                <tr>
                                    <td>Area</td>
                                    <td>{{contrato.area.nombre}}</td>
                                </tr>
                                <tr>
                                    <td>Solucion</td>
                                    <td>{{contrato.solucion}}</td>
                                </tr>
                                <tr>
                                    <td>Marca</td>
                                    <td>{{contrato.marca}}</td>
                                </tr>
                            </tbody>

                        </table>
                        <button type="submit" class="btn btn-primary" :disabled="!tareas.length>0" >Enviar {{parseInt(diferencia)}} tareas</button>
                    </div>

                </div>


            </div>
        </div>
    </form>
</div>


</template>
<script>
import moment from "moment";

export default {
    data() {
        return {
            contrato: {},
            frecuencias: {},
            usuarios: [],
            tareas: {},
            request: {},
            diferencia:0,
            dias: [
                { text: "LUNES", value: 1 },
                { text: "MARTES", value: 2 },
                { text: "MIERCOLES", value: 3 },
                { text: "JUEVES", value: 4 },
                { text: "VIERNES", value: 5 },
                { text: "SABADO", value: 6 },
                { text: "DOMINGO", value: 7 }
            ],
            tipo_tareas: [],
            datos: []
        };
    },
    created() {

        this.axios
            .get("/api/frecuencias/")
            .then(response => {
                this.frecuencias = response.data;
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
        //console.log(moment().format('MMMM Do YYYY, h:mm:ss a'));
    },
    methods: {
        addTarea() {


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
                                icon: 'success'
                                })

                    })
                    .catch(err => console.log(err))
                    .finally(() => this.$router.go())
        },
        deleteTarea(id) {
            let i = this.tareas.map(data => data.id).indexOf(id);
            this.tareas.splice(i, 1);
            this.diferencia--;
        },
        generarFechas() {
            this.datos  = [];
            let fecha_inicio = moment(this.contrato.fecha_inicio);
            let fecha_fin = moment(this.contrato.fecha_fin);
            let frecuencia = this.frecuencias.value;
            let num_dia = this.dias.value;
            let dia_preferido;
            //let diferencia;
            let alerta;
            switch (frecuencia) {
                case 2: //semanal
                alerta=2;
                    this.diferencia = parseInt(fecha_fin.diff(fecha_inicio, "weeks")) + parseInt(1);
                    for (let i = 1; i < parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("week");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                id: i,
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dias.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuarios.value,
                                tipo_tarea: this.tipo_tareas.value,
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
                    alerta=5;
                    this.diferencia = parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1);
                    for (let i = 1; i <= parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                id: i,
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dias.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuarios.value,
                                tipo_tarea: this.tipo_tareas.value,
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
                    alerta=15;

                    this.diferencia = (parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1))/3;
                    for (let i = 1; i <= parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                               id: i,
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dias.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuarios.value,
                                tipo_tarea: this.tipo_tareas.value,
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
                    alerta=30;

                    this.diferencia = (parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1))/6;
                    for (let i = 1; i <= parseInt(this.diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                id: i,
                                contrato_id: this.contrato.id,
                                dia_elegido: this.dias.value,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                responsable: this.usuarios.value,
                                tipo_tarea: this.tipo_tareas.value,
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
                    alerta=45;

                    this.diferencia = parseInt(fecha_fin.diff(fecha_inicio, "years")) + parseInt(1);
                    break;
            }

           // console.log("tareas:" + diferencia);

            this.tareas = this.datos;
            //console.log(JSON.stringify(this.mantenimientos));
            this.$toasted.success('Tareas generadas correctamente');

        }
    }
};
</script>
