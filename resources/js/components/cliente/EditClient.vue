<template>
    <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Editar cliente</h5>
            </div>
       <div class="card-body">
                <form @submit.prevent="updateClient">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                        <label for="tipo_identificacion" class="form-label">Tipo de identificacion:</label>
                        <select
                                v-model="client.tipo_identificacion.id"
                                class="form-control"
                            >
                                <option
                                    v-for="item in tipo_identificacion"
                                    v-bind:key="item.id"
                                    v-bind:value="item.id"
                                >
                                    {{ item.nombre }}
                                </option>
                            </select>
                        </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="dni" class="form-label">Numero de identificacion:</label>
                                <input type="text" class="form-control" v-model="client.dni" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                        <label for="razon_social" class="form-label">Razon social:</label>
                        <input type="text" class="form-control"  v-model="client.razon_social" required>
                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                        <label for="nombre_comercial" class="form-label">Nombre comercial:</label>
                        <input type="text" class="form-control" v-model="client.nombre_comercial" required>
                    </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                        <label for="correo" class="form-label">Correo electronico</label>
                        <input type="email" class="form-control"  v-model="client.correo"  required>
                    </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="tel" class="form-control" v-model="client.telefono" required>
                    </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" v-model="client.direccion" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
</template>

<script>
    export default {
        data() {
            return {
                client: {},
                tipo_identificacion: {},

            }
        },
        created() {
            this.axios
                .get(`/api/clientes/${this.$route.params.id}`)
                .then((res) => {
                    this.client = res.data;
                    console.log(res.data);
                });
                this.axios
                .get('/api/tipo-identificacion')
                .then(response => {
                    this.tipo_identificacion = response.data;
                    console.log(response.data);
                });
        },
        methods: {
            updateClient() {
                this.axios
                    .patch(`/api/clientes/${this.$route.params.id}`, this.client)
                    .then((res) => {
                        this.$router.push({ name: 'clientes' });
                    });
            }
        }
    }
</script>
