<template>
    <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">Contratos</h5>
                    <router-link to="/contratos/create" class="btn btn-primary btn-sm">Nuevo</router-link>
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Nuevo
                    </button> -->
                </div>

                <div class="card-body">
                    <table class="table ">
                        <thead class="table-dark">
                            <tr>
                                <th>Id</th>
                                <th>Descripcion</th>
                                <th>Cliente</th>
                                <th>Fecha inicial</th>
                                <th>Fecha final</th>
                                <th>Area</th>
                                <th>Solucion</th>
                                <th>Marca</th>
                                <th>Mantenimientos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr v-for="item in contratos" :key="item.id">
                                    <td>{{ $item.id}}</td>
                                    <td>{{ $item.descripcion}}</td>
                                    <td>{{ $item.cliente.nombre_comercial}}</td>
                                    <td>{{ $item.fecha_inicio}}</td>
                                    <td>{{ $item.fecha_fin}}</td>
                                    <td>{{ $item.area.descripcion}}</td>
                                    <td>{{ $item.solucion}}</td>
                                    <td>{{ $item.marca}}</td>

                                    <td>
                                    </td>
                                    <td><button class="btn btn-warning btn-sm" >Mant</button></td>
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
                contratos: []
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/contratos/')
                .then(response => {
                    this.contratos = response.data;
                    console.log(response.data);
                });
        },
        methods: {
            deleteClient(id) {
                this.axios
                    .delete(`http://localhost:8000/api/contratos/${id}`)
                    .then(response => {
                        let i = this.contratos.map(data => data.id).indexOf(id);
                        this.contratos.splice(i, 1)
                    });
            }
        }
    }
</script>
