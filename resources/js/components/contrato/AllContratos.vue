<template>
    <div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Contratos</h5>
                <router-link
                    to="/contratos/create"
                    class="btn btn-primary btn-sm"
                    >Nuevo</router-link
                >
                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Nuevo
                    </button> -->
            </div>

            <div class="card-body">
                <table class="table ">
                    <thead class="table-dark">
                        <tr>
                            <th>Descripcion</th>
                            <th>Cliente</th>
                            <th>Fecha inicial</th>
                            <th>Fecha final</th>
                            <th>Area</th>
                            <th>Solucion</th>
                            <th>Marca</th>
                            <th>Tareas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in contratos" :key="item.id">
                            <td>{{ item.descripcion }}</td>
                            <td>{{ item.cliente.nombre_comercial }}</td>
                            <td>{{ item.fecha_inicio }}</td>
                            <td>{{ item.fecha_fin }}</td>
                            <td>{{ item.area.nombre }}</td>
                            <td>{{ item.solucion }}</td>
                            <td>{{ item.marca }}</td>

                            <td>
                                <!-- <div
                                    v-for="mant in item.mantenimiento"
                                    :key="mant.id"
                                >
                                    <span class="badge badge-success">{{
                                        mant.fecha
                                    }}</span>
                                </div> -->
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                            <router-link :to="{name: 'contratos-edit', params: { id: item.id }}" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                            </router-link>

                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-envelope"></i>
                                </button>
                                </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            contratos: [],
            mantenimientos: {},

        };
    },
    created() {
        this.axios
            .get("http://localhost:8000/api/contratos/")
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
                    this.contratos.splice(i, 1);
                });
        }
    }
};
</script>
