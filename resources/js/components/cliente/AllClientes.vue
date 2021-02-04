<template>
    <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">Clientes</h5>
                    <router-link to="/clientes/create" class="btn btn-primary btn-sm">Nuevo</router-link>

                </div>

                <div class="card-body">
                    <table class="table ">
                        <thead class="table-dark">
                            <tr>
                                <th>Id</th>
                                <th>Razon social</th>
                                <th>Nombre comercial</th>
                                <th>Correo</th>
                                <th>Telefono</th>
                                <th>Direccion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr v-for="cliente in clientes" :key="cliente.id">
                                    <td>{{ cliente.id}}</td>
                                    <td>{{ cliente.razon_social}}</td>
                                    <td>{{ cliente.nombre_comercial}}</td>
                                    <td>{{ cliente.correo}}</td>
                                    <td>{{ cliente.telefono}}</td>
                                    <td>{{ cliente.direccion}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <router-link :to="{name: 'clientes-edit', params: { id: cliente.id }}" class="btn btn-success">
                                                <i class="fas fa-edit"></i>
                                            </router-link>
                                            <button class="btn btn-danger" @click="deleteClient(cliente.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
</template>

<script>
    export default {
        data() {
            return {
                clientes: []
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/clientes/')
                .then(response => {
                    this.clientes = response.data;
                    console.log(response.data);
                });
        },
        methods: {
            deleteClient(id) {
                this.axios
                    .delete(`http://localhost:8000/api/clientes/${id}`)
                    .then(response => {
                        let i = this.clientes.map(data => data.id).indexOf(id);
                        this.clientes.splice(i, 1)
                    });
            }
        }
    }
</script>
