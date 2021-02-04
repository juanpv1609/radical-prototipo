<template>

        <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">Areas</h5>
                    <router-link to="/areas/create" class="btn btn-primary btn-sm">Nuevo</router-link>

                </div>

                <div class="card-body">
                    <table class="table ">
                        <thead class="table-dark">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr v-for="area in areas" :key="area.id">
                                    <td>{{ area.id}}</td>
                                    <td>{{ area.nombre}}</td>
                                    <td>{{ area.descripcion}}</td>
                                    <td>{{ area.estado}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <router-link :to="{name: 'areas-edit', params: { id: area.id }}"
                                            class="btn btn-success">Edit</router-link>
                                            <button class="btn btn-danger" @click="deleteArea(area.id)">Delete</button>
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
                areas: []
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/areas/')
                .then(response => {
                    this.areas = response.data;
                    console.log(response.data);
                });
        },
        methods: {
            deleteArea(id) {
                this.axios
                    .delete(`http://localhost:8000/api/areas/${id}`)
                    .then(response => {
                        let i = this.areas.map(data => data.id).indexOf(id);
                        this.areas.splice(i, 1)
                        
                    });
            }
        }
    }
</script>
