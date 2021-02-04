<template>
<div>

<form @submit.prevent="addContrato">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Nuevo contrato</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
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
                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label"
                                >Fecha inicial:</label
                            >
                            <input
                                type="date"
                                class="form-control"
                                v-model="contrato.fecha_inicio"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label"
                                >Fecha final:</label
                            >
                            <input
                                type="date"
                                class="form-control"
                                v-model="contrato.fecha_fin"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-sm-2">
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
                    <div class="col-sm-2">
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
                                    {{ item.nombre }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
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
                </div>
                <div class="row">


                    <div class="col-sm-2">
                        <div class="mb-3">
                            <label for="marca" class="form-label">Marca:</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="contrato.marca"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-sm-2">
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
                    <div class="col-sm-5">
                        <div class="mb-3">
                            <label for="correos">Direcciones de correo para las alertas</label>
                            <input-tag v-model="correos" class="form-control" placeholder="Ingrese una direccion de correo" validate="email" ></input-tag>
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

                <div class="row" v-if="mantenimientos.length > 0">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-4">

                    </div>
                </div>
            </div>
            <div class="card-footer ">
                <div class="d-flex justify-content-between">

                <button type="button" :disabled="!mantenimientos.length>0" class="btn btn-secondary" data-toggle="modal" data-target="#exampleModal">Ver Tareas</button>

                <button type="submit" class="btn btn-primary">Enviar</button>
                </div>

            </div>
        </div>
</form>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tareas programadas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-sm">
            <thead class="table-dark">
                <tr>
                    <th style="width: 10%">#</th>
                    <th>Fecha</th>
                    <th style="width: 20%">Alerta</th>
                    <th style="width: 10%"></th>
                </tr>
            </thead>
                <tbody>
                    <tr
                        v-for="value in mantenimientos"
                        v-bind:key="value.tarea_id"
                    >
                        <td>{{ value.tarea_id }}</td>
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
                                v-on:click="deleteTarea(value.tarea_id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </th>
                    </tr>
                </tbody>
            </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</div>


</template>
<script>
import moment from "moment";

export default {
    data() {
        return {
            request: {},
            contrato: {},
            clientes: {},
            paises: {},
            areas: {},
            frecuencias: {},
            mantenimientos: {},
            correos:[],
            dias: [
                { text: "LUNES", value: 1 },
                { text: "MARTES", value: 2 },
                { text: "MIERCOLES", value: 3 },
                { text: "JUEVES", value: 4 },
                { text: "VIERNES", value: 5 },
                { text: "SABADO", value: 6 },
                { text: "DOMINGO", value: 7 }
            ],
            datos: []
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

            this.contrato.mantenimientos=this.mantenimientos;
            this.contrato.correos=this.correos;
            console.log(JSON.stringify(this.contrato));

            this.axios
                    .post('http://localhost:8000/api/contratos', this.contrato)
                    .then(response => (
                        this.$router.push({ name: 'contratos' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
        },
        deleteTarea(tarea_id) {
            let i = this.mantenimientos.map(data => data.tarea_id).indexOf(tarea_id);
            this.mantenimientos.splice(i, 1);
        },
        generarFechas() {
            this.datos  = [];
            let fecha_inicio = moment(this.contrato.fecha_inicio);
            let fecha_fin = moment(this.contrato.fecha_fin);
            let frecuencia = this.contrato.frecuencia;
            let num_dia = this.dias.value;
            let dia_preferido;
            let diferencia;
            switch (frecuencia) {
                case 2: //semanal
                    diferencia = parseInt(fecha_fin.diff(fecha_inicio, "weeks")) + parseInt(1);
                    for (let i = 1; i < parseInt(diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("week");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                tarea_id: i,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                alerta: 15
                            });
                            fecha_inicio.add(1, "weeks");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }

                    break;
                case 3: //mensual
                    diferencia = parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1);
                    for (let i = 1; i <= parseInt(diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                tarea_id: i,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                alerta: 15
                            });
                            fecha_inicio.add(1, "months");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }
                    break;
                case 4: //trimestral
                    diferencia = (parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1))/3;
                    for (let i = 1; i <= parseInt(diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                tarea_id: i,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                alerta: 15
                            });
                            fecha_inicio.add(3, "months");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }

                    break;
                case 5: //semestral
                    diferencia = (parseInt(fecha_fin.diff(fecha_inicio, "months")) + parseInt(1))/6;
                    for (let i = 1; i <= parseInt(diferencia); i++) {
                        dia_preferido = moment(fecha_inicio).startOf("month");
                        while (dia_preferido.day() !== parseInt(num_dia)) {
                            dia_preferido.add(1, "day");
                        }
                        if (dia_preferido.day() == parseInt(num_dia)) {
                            this.datos.push({
                                tarea_id: i,
                                fecha: moment(dia_preferido).format( "YYYY-MM-DD"),
                                alerta: 15
                            });
                            fecha_inicio.add(6, "months");
                        } else {
                            fecha_inicio.add(1, "days");
                        }
                    }

                    break;
                default:
                    //anual
                    diferencia = parseInt(fecha_fin.diff(fecha_inicio, "years")) + parseInt(1);
                    break;
            }

           // console.log("tareas:" + diferencia);

            this.mantenimientos = this.datos;
            //console.log(JSON.stringify(this.mantenimientos));
            this.$toasted.success('Tareas generadas correctamente');

        }
    }
};
</script>
