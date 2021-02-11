<template>
    <v-card elevation="2" :loading="loading">
        <v-card-title>
            Tareas asignadas
        </v-card-title>
        <v-card-text>
            <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search"
                single-line
                hide-details
            ></v-text-field>
            <v-data-table
                :headers="headers"
                :items="tareas"
                :search="search"
            >
            <template v-slot:item="row">
                <tr>
                    <td>{{row.item.fecha}}</td>
                    <td>{{row.item.fecha_alerta}}</td>
                    <td>{{row.item.ticket}}</td>
                    <td>{{row.item.usuario.name}}</td>
                    <td>{{row.item.contrato.cliente.nombre_comercial}}</td>
                    <td>{{row.item.contrato.solucion}}</td>
                    <td>{{row.item.tipo.nombre}}</td>
                    <td>
                        <v-btn  icon color="primary" @click="downloadFile(row.item.adjunto)" target="_blank"
                        :disabled="row.item.adjunto==null || row.item.adjunto==''">
                            <v-icon dark>mdi-download</v-icon>
                            </v-btn>
                    </td>
                    <td>
                        <label v-if="row.item.estado_tarea.id==1"
                            class="badge badge-warning">
                                {{ row.item.estado_tarea.descripcion}}
                        </label>
                        <label v-else-if="row.item.estado_tarea.id==2"
                            class="badge badge-success">
                                {{ row.item.estado_tarea.descripcion}}
                        </label>
                        <label v-else-if="row.item.estado_tarea.id==3"
                            class="badge badge-danger">
                                {{ row.item.estado_tarea.descripcion}}
                        </label>
                        <label v-else-if="row.item.estado_tarea.id==4"
                            class="badge badge-info">
                                {{ row.item.estado_tarea.descripcion}}
                        </label>
                    </td>
                    <td>
                        <v-btn  icon color="success" :to="{
                                    name: 'tareas-edit',
                                    params: { id: row.item.id }
                                }">
                        <v-icon dark>mdi-pencil</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </template>
            </v-data-table>
        </v-card-text>
    </v-card>
</template>

<script>
import moment from "moment";

    export default {
        data() {
            return {
                tareas: [],
                loading: true,
                dialog: false,
                search: "",
                headers: [
                { text: "Fecha vencimiento", value: "fecha" },
                { text: "Fecha alerta", value: "fecha_alerta" },
                { text: "Ticket", value: "ticket" },
                { text: "Responsable", value: "usuario.name" },
                { text: "Cliente", value: "contrato.cliente.nombre_comercial" },
                { text: "Solucion", value: "contrato.solucion" },
                { text: "Tipo", value: "tipo.nombre" },
                { text: "Adjuntos", value: "adjunto" },
                { text: "Estado", value: "estado_tarea" },
                { text: "Acciones", value: "controls", sortable: false }
            ]

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
                    console.log(this.tareas);
                    this.loading = false;
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
