<template>
    <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">Tareas asiganadas</h5>
                        <!-- <router-link to="/clientes/create" class="btn btn-primary btn-sm">Nuevo</router-link> -->

                </div>

                <div class="card-body">
                    <table class="table table-sm" v-if="tareas.length>0">
                        <thead class="table-dark">
                            <tr>
                                <th>Fecha vencimiento</th>
                                <th>Fecha alerta</th>
                                <th>Ticket</th>
                                <th>Cliente</th>
                                <th>Solucion</th>
                                <th>Tipo</th>
                                <th>Adjuntos</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr v-for="tarea in tareas" :key="tarea.id">
                                    <td>{{ tarea.fecha}}</td>
                                    <td>{{ tarea.fecha_alerta}}</td>
                                    <td>{{ tarea.ticket}}</td>
                                    <td>{{ tarea.contrato.cliente.nombre_comercial}}</td>
                                    <td>{{ tarea.contrato.solucion}}</td>
                                    <td>{{ tarea.tipo.nombre}}</td>
                                    <td><button target="_blank" class="btn btn-link" type="button"
                                            :disabled="tarea.adjunto==null || tarea.adjunto==''"
                                            @click="downloadFile(tarea.adjunto)">
                                        <i class="fas fa-download"></i>
                                        </button></td>
                                    <td>
                                        <label v-if="tarea.estado_tarea.id==1"
                                            class="badge badge-warning">
                                                {{ tarea.estado_tarea.descripcion}}
                                        </label>
                                        <label v-else-if="tarea.estado_tarea.id==2"
                                            class="badge badge-success">
                                                {{ tarea.estado_tarea.descripcion}}
                                        </label>
                                        <label v-else-if="tarea.estado_tarea.id==3"
                                            class="badge badge-danger">
                                                {{ tarea.estado_tarea.descripcion}}
                                        </label>
                                        <label v-else-if="tarea.estado_tarea.id==4"
                                            class="badge badge-info">
                                                {{ tarea.estado_tarea.descripcion}}
                                        </label>
                                        </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <router-link :to="{name: 'tareas-edit', params: { id: tarea.id }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </router-link>
                                            <!-- <button class="btn btn-danger" @click="deleteClient(tarea.id)">
                                                <i class="fas fa-trash"></i>
                                            </button> -->
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                    <p v-else class="alert alert-info">No se encontraron resultados :(</p>
                </div>
            </div>
</template>

<script>
import moment from "moment";

    export default {
        data() {
            return {
                tareas: [],

            }
        },
        /* beforeRouteEnter (to, from, next) {
            if (to.query.redirectFrom) {
                    next(vm => {
                    alert('Sorry, you have to login first!')
                    })
            } else {
            next()
            }
        }, */
        created() {
            this.axios
                .get('/api/tareas')
                .then(response => {
                    this.tareas = response.data;
                });
        },
        methods: {
            downloadFile(archivo){
                console.log(archivo);
                let arrayArchivos = archivo.split(',');
                for (const file of arrayArchivos) {
                    this.axios
                        .get(`/api/get-file/${file}`)
                        .then(response => {
                            const url=response.config.baseURL+response.config.url;
                            window.open(url,'_blank');
                        },error => {
                            console.log(error);
                            this.$toasted.error(`No se encontro el archivo: ${file}`)

                        });
                }

            },
            deleteClient(id) {
                this.axios
                    .delete(`/api/clientes/${id}`)
                    .then(response => {
                        let i = this.clientes.map(data => data.id).indexOf(id);
                        this.clientes.splice(i, 1)
                    });
            }
        }
    }
</script>
