<template >
    <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Nuevo cliente</h5>
            </div>
            <div class="card-body">
                <form  @submit.prevent="addClient" >
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                        <label for="razon_social" class="form-label">Razon social:</label>
                        <input type="text" class="form-control"  v-model="client.razon_social" required>
                    </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                        <label for="nombre_comercial" class="form-label">Nombre comercial:</label>
                        <input type="text" class="form-control" v-model="client.nombre_comercial" required>
                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                        <label for="correo" class="form-label">Correo electronico</label>
                        <input type="email" class="form-control"  v-model="client.correo"  required>
                    </div>
                        </div>
                        <div class="col-sm-6">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                    </div>
            </div>
</template>
<script>
    export default {
        data() {
            return {
                client: {}
            }
        },
        methods: {
            addClient() {
                this.axios
                    .post('http://localhost:8000/api/clientes', this.client)
                    .then(response => (
                        this.$router.push({ name: 'clientes' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>
