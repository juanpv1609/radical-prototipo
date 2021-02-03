<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5 class="card-title">Nuevo cliente</h5>
        </div>
        <div class="card-body">
            <form @submit.prevent="addContrato">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="cliente" class="form-label"
                                >Seleccione un cliente:</label
                            >
                            <select
                                v-model="contrato.cliente"
                                class="form-control"
                            >
                                <option
                                    v-for="item in clientes"
                                    v-bind:key="item.id"
                                    v-bind:value="item.id"
                                >
                                    {{ item.nombre_comercial }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label"
                                >Fecha inicio:</label
                            >
                            <input
                                type="date"
                                class="form-control"
                                v-model="contrato.fecha_inicio"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label"
                                >Fecha fin:</label
                            >
                            <input
                                type="date"
                                class="form-control"
                                v-model="contrato.fecha_fin"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="pais" class="form-label">Pais:</label>
                            <select
                                v-model="contrato.pais"
                                class="form-control"
                            >
                                <option
                                    v-for="item in paises"
                                    v-bind:key="item.id"
                                    v-bind:value="item.id"
                                >
                                    {{ item.nombre }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="area" class="form-label">Area:</label>
                            <select
                                v-model="contrato.area"
                                class="form-control"
                            >
                                <option
                                    v-for="item in areas"
                                    v-bind:key="item.id"
                                    v-bind:value="item.id"
                                >
                                    {{ item.descripcion }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="solucion" class="form-label"
                                >Solucion:</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                v-model="contrato.solucion"
                                required
                            />
                        </div>
                    </div>
                    <!-- <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="marca" class="form-label">Marca:</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="contrato.marca"
                                required
                            />
                        </div>
                    </div> -->
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="frecuencia" class="form-label"
                                >Frecuencia:</label
                            >
                            <select
                                v-model="contrato.frecuencia"
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
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <label for="dias" class="form-label"
                                >Cada dia:</label
                            >
                            <select
                                v-model="dias.value"
                                class="form-control"
                            >
                                <option
                                    v-for="item in dias"
                                    v-bind:key="item.value"
                                    v-bind:value="item.value"
                                >
                                    {{ item.text }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="direccion" class="form-label"
                                >Descripcion del contrato</label
                            >
                            <textarea
                                n
                                class="form-control"
                                v-model="contrato.descripcion"
                                cols="30"
                                rows="3"
                            ></textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="observacion" class="form-label"
                                >Observaciones</label
                            >
                            <textarea
                                class="form-control"
                                v-model="contrato.observaciones"
                                cols="30"
                                rows="3"
                            ></textarea>
                        </div>
                    </div>
                </div>
                <button v-on:click="generarFechas" class="btn btn-info">
                    Generar Fechas
                </button>
                <div class="row" v-if="mantenimientos.length>0">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <table class="table">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th style="width:20%">Alerta</th>
                                    <th style="width:20%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="value in mantenimientos" v-bind:key="value.fecha">
                                    <td> <input type="date" class="form-control form-control-sm" v-model="value.fecha"></td>
                                    <td> <input type="text" class="form-control form-control-sm" v-model="value.alerta"></td>
                                    <td> <button class="btn btn-sm btn-danger" @click="deleteMantenimiento(value.fecha)">X</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</template>
<script>
import moment from "moment";

export default {
    data() {
        return {
            contrato: {},
            clientes: {},
            paises: {},
            areas: {},
            frecuencias: {},
            mantenimientos: {},
            options: ['list', 'of', 'options'],
            dias:[
                { text: 'LUNES',value:1},
                { text: 'MARTES',value:2},
                { text: 'MIERCOLES',value:3},
                { text: 'JUEVES',value:4},
                { text: 'VIERNES',value:5},
                { text: 'SABADO',value:6},
                { text: 'DOMINGO',value:7},
            ],
            datos:[]
        };
    },
    created() {
        this.axios.get("http://localhost:8000/api/clientes/").then(response => {
            this.clientes = response.data;
            //console.log('clientes'+response.data);
        });
        this.axios.get("http://localhost:8000/api/paises/").then(response => {
            this.paises = response.data;
            //console.log(response.data);
        });
        this.axios.get("http://localhost:8000/api/areas/").then(response => {
            this.areas = response.data;
            //console.log(response.data);
        });
        this.axios
            .get("http://localhost:8000/api/frecuencias/")
            .then(response => {
                this.frecuencias = response.data;
                //console.log(response.data);
            });
        //console.log(moment().format('MMMM Do YYYY, h:mm:ss a'));
    },
    methods: {
        addContrato() {
            console.log(this.contrato);
            this.data = {
                cliente: this.selectedCliente,
                fecha_inicio: this.c
            };
            /* this.axios
                    .post('http://localhost:8000/api/contratos', this.client)
                    .then(response => (
                        this.$router.push({ name: 'contratos' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false) */
        },
        deleteMantenimiento(fecha) {
                        let i = this.mantenimientos.map(data => data.fecha).indexOf(fecha);
                        this.mantenimientos.splice(i, 1)
            },
        generarFechas() {
            //var datos  = [];
            let fecha_inicio = moment(this.contrato.fecha_inicio);
            let fecha_fin = moment(this.contrato.fecha_fin);
            let frecuencia = this.contrato.frecuencia;
            let num_dia = this.dias.value;
            //console.log(num_dia);
            let salto=0;
            let diferencia_dias = parseInt(fecha_fin.diff(fecha_inicio,'days'))+parseInt(1);
            //console.log(''+fecha_inicio.format("d"));
             switch (frecuencia) {

                case 2: //semanal
                    salto = 7;
                    break;
                case 3: //mensual
                    salto = 30;
                    break;
                case 4: //trimestral
                    salto = 90;
                    break;
                case 5: //semestral
                    salto = 180;
                    break;
                default:
                    //anual
                    salto = 365;
                    break;
            }
            //console.log(moment().startOf("month").startOf("isoweek"));
            // let result = moment().startOf("month");
            // console.log(num_dia);
            //     while (result.day() !== parseInt(num_dia)) {
            //     result.add(1, "day");
            //     }
            //     console.log(result);
            while (salto<=parseInt(diferencia_dias)) { // de 7 en



                this.datos.push({
                    'fecha' : moment(fecha_inicio).add(salto,'days').format("YYYY-MM-DD"),
                    'alerta' : 15
                });
                // const mant = {
                //             'fecha' : moment(fecha_inicio).add(salto,'days').format("DD-MM-YYYY")
                //         };

                        //this.mantenimientos.push(mant);
                        salto+=salto;
            }
            this.mantenimientos = this.datos;

        }
    }
};
</script>
