<template>
<div>
    <v-card elevation="2" :loading="loading">
        <v-card-title  >
            Tareas asignadas
        </v-card-title>
        <v-card-text>
            <v-col cols="6" >
                <v-menu
                ref="menu"
                v-model="menu"
                :close-on-content-click="false"
                :return-value.sync="date"
                transition="scale-transition"
                offset-y
                min-width="auto"
            >
                <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="search"
                    label="Filtro por Fecha"
                    readonly
                    clearable
                    prepend-inner-icon="mdi-calendar"
                    v-bind="attrs"
                    v-on="on"
                ></v-text-field>
                </template>
                <v-date-picker
                v-model="search"
                no-title
                scrollable
                >
                </v-date-picker>
            </v-menu>
            </v-col>

            <v-data-table
                :headers="headers"
                :items="tareas"
                :search="search"
            >
            <template v-slot:item="row">
                <tr >
                    <td>{{row.item.fecha}}</td>
                    <td>{{row.item.ticket}}</td>
                    <td>{{row.item.usuario.name}}</td>
                    <td>{{row.item.contrato.cliente.nombre_comercial}}</td>
                    <td>{{row.item.tipo.nombre}}</td>
                    <td>{{row.item.descripcion}}</td>
                    <td>
                        <v-btn  icon color="primary" @click="downloadFile(row.item.adjunto)" target="_blank"
                        :disabled="row.item.adjunto==null || row.item.adjunto==''">
                            <v-icon dark>mdi-download</v-icon>
                            </v-btn>
                    </td>
                    <td>
                        <v-chip v-if="row.item.estado_tarea.id==1"
                            class="ma-2"
                            small
                            color="orange"

                            text-color="white"
                            > {{ row.item.estado_tarea.descripcion}}
                            </v-chip>
                            <v-chip v-else-if="row.item.estado_tarea.id==2"
                            class="ma-2"
                            small
                            color="green"
                            text-color="white"
                            > {{ row.item.estado_tarea.descripcion}}
                            </v-chip>
                            <v-chip v-else-if="row.item.estado_tarea.id==3"
                            class="ma-2"
                            small
                            color="red"
                            text-color="white"
                            > {{ row.item.estado_tarea.descripcion}}
                            </v-chip>
                            <v-chip v-else-if="row.item.estado_tarea.id==4"
                            class="ma-2"
                            small
                            color="blue-grey"
                            text-color="white"
                            > {{ row.item.estado_tarea.descripcion}}
                            </v-chip>
                    </td>
                    <td>
                        <v-btn :disabled="row.item.estado_tarea.id==3"  icon color="grey darken-3"
                        @click="editTarea(row.item)">
                        <v-icon dark>mdi-pencil</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </template>
            </v-data-table>
        </v-card-text>
    </v-card>
    <template>
        <v-row justify="center">
            <v-dialog v-model="dialog" persistent max-width="700px">
                <v-card elevation="2" >
                <v-card-title Tarea class="d-flex justify-space-between mb-6"
                    ><h4>{{tarea.descripcion}}</h4>
                    <h5>{{tarea.fecha}}</h5>
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field
                                v-model="tarea.ticket"
                                label="Ticket"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-select :items="estado_tarea"
                                v-model="tarea.estado"
                                    label="Estado" >
                                    <template slot="selection" slot-scope="data">
                                        <!-- HTML that describe how select should render selected items -->
                                        {{ data.item.descripcion }}
                                    </template>
                                    <template slot="item" slot-scope="data">
                                        <!-- HTML that describe how select should render items when the select is open -->
                                        {{ data.item.descripcion }}
                                    </template>
                                </v-select>
                        </v-col>
                        </v-row>
                    <v-row>
                        <v-col cols="6">
                            <v-file-input
                                small-chips
                                multiple
                                v-model="files"
                                label="Seleccione archivo/s"
                                >
                                </v-file-input>
                                 <v-btn  color="success" block v-if="files.length>0"
                            @click="subirArchivos"
                            :loading="loadingUpload"
                            :disabled="status_archivos">
                            <span v-if="status_archivos">CORRECTO</span>
                                    <span v-else>Subir {{files.length}} Archivos</span>
                                    </v-btn>
                        </v-col>
                        <v-col cols="6" >
                            <v-textarea
                                clearable
                                clear-icon="mdi-close-circle"
                                label="Observaciones"
                                v-model="tarea.observacion"
                                rows="2"
                                ></v-textarea>

                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                            color="error"
                            text
                            @click="dialog = false"
                        >
                            Cerrar
                        </v-btn>
                    <v-btn  text color="primary"
                            @click="updateTarea">
                        Actualizar
                        </v-btn>
                </v-card-actions>
    </v-card>
            </v-dialog>
        </v-row>
    </template>
</div>

</template>

<script>
import moment from "moment";

    export default {
        data() {
            return {
                date: new Date().toISOString().substr(0, 10),
            menu: false,
                tareas: [],
                loading: true,
                dialog: false,
                search: "",
                headers: [
                { text: "Fecha entrega", value: "fecha" },
                { text: "Ticket", value: "ticket" },
                { text: "Responsable", value: "usuario.name" },
                { text: "Cliente", value: "contrato.cliente.nombre_comercial" },
                { text: "Tarea", value: "tipo.nombre" },
                { text: "Entregable", value: "descripcion" },
                { text: "Adjuntos", value: "adjunto",sortable: false, filterable: false },
                { text: "Estado", value: "estado_tarea",align:'center',sortable: false, filterable: false },
                { text: "Acciones", value: "controls", sortable: false }
            ],
            tarea: {},
                estado_tarea: [],
                files:[],
                ruta_archivo:[],
                status_archivos:false,
            loadingUpload: false,
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
                    this.axios.get("/api/estado-tareas/").then(response => {
                    this.estado_tarea = response.data;
                });
        },
        methods: {
            editTarea(el) {
                console.log(el);
                this.files = [];
                this.ruta_archivo = [];
                this.tarea.id = el.id;
                this.tarea.descripcion = el.descripcion;
                this.tarea.fecha = el.fecha;
                this.tarea.estado = el.estado;
                this.tarea.ticket = el.ticket;
                this.tarea.observacion = el.observacion;
                this.titleForm = "Editar Tarea";
                this.dialog = true;
            },
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
            deleteFile(name) {
                let i = this.files.map(data => data.name).indexOf(name);
                this.files.splice(i, 1);
                //this.file.length=this.file.length-1;
            },
            subirArchivos(){
                this.loadingUpload=true;
                console.log(this.files);
                const config = {
                    headers: { 'enctype': 'multipart/form-data' }
                }
                //console.log(this.files);
                for (const file of this.files) {
                    let formData = new FormData();
                    formData.append('file', file);
                     this.axios
                    .post(`/api/subir-archivo`, formData,config)
                    .then((res) => {
                        //this.$router.push({ name: 'tareas' });
                        console.log(res)
                        this.ruta_archivo.push(res.data.archivo);
                        console.log(this.ruta_archivo);
                    }).catch((error)=>{
                        console.log(error);
                    });
                }
                this.loadingUpload=false;
                this.status_archivos=true;
            },
            updateTarea(e) {
                e.preventDefault();
                this.tarea.adjuntos=this.ruta_archivo;
                this.tarea.estado=this.tarea.estado.id;
                console.log(this.tarea);
                this.axios
                    .patch(`/api/tareas/${this.tarea.id}`, this.tarea)
                    .then((res) => {
                        this.dialog = false;
                        this.loading = false;
                        this.axios
                        .get('/api/tareas')
                        .then(response => {
                            this.tareas = response.data;
                            console.log(this.tareas);
                            this.loading = false;
                        });
                            this.axios.get("/api/estado-tareas/").then(response => {
                            this.estado_tarea = response.data;
                        });
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false);
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
