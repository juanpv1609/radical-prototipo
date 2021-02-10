<template>
<div>

<form @submit.prevent="addContrato">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Nuevo contrato</h5>
            </div>
            <div class="card-body">
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
                    <div class="col-sm-3">
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
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label for="correos">Direcciones de correo</label>
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
                <div class="d-flex justify-content-end">


                <button type="submit" class="btn btn-primary">Enviar</button>
                </div>

            </div>
        </div>
</form>

</div>


</template>
<script>

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
        this.axios.get("/api/clientes/").then(response => {
            this.clientes = response.data;
            //console.log('clientes'+response.data);
        });
        this.axios.get("/api/paises/").then(response => {
            this.paises = response.data;
            //console.log(response.data);
        });
        this.axios.get("/api/areas/").then(response => {
            this.areas = response.data;
            //console.log(response.data);
        });
        this.axios
            .get("/api/frecuencias/")
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
                    .post('/api/contratos', this.contrato)
                    .then(response => (
                        this.$router.push({ name: 'contratos' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
        }

    }
};
</script>
