<template>
    <v-card elevation="2" >
                <v-card-title Tarea class="d-flex justify-space-between mb-6"
                    >Editar Tarea
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="4">
                            <v-text-field
                                v-model="tareas.contrato.cliente.nombre_comercial"
                                label="Cliente" readonly
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field
                                v-model="tareas.fecha"
                                label="Fecha" readonly
                            ></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field
                                v-model="tareas.tipo.nombre"
                                label="Tipo Tarea" readonly

                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="3">
                            <v-text-field
                                v-model="tareas.ticket"
                                label="Ticket"
                            ></v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-select :items="estado_tarea"
                                v-model="tareas.estado"
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
                        <v-col cols="6">
                            <v-file-input
                                small-chips
                                multiple
                                v-model="files"
                                label="Seleccione archivo/s"
                                >
                                </v-file-input>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <v-textarea
                                clearable
                                clear-icon="mdi-close-circle"
                                label="Observaciones"
                                v-model="tareas.observacion"
                                ></v-textarea>
                        </v-col>
                        <v-col cols="6" v-if="files.length>0">
                            <v-btn  text color="success" block
                            @click="subirArchivos"
                            :disabled="status_archivos">
                                   Subir <strong>{{files.length}}</strong> Archivos
                                    </v-btn>
                             <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Archivo</th>
                                            <th>Tamaño</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in files" :key="item.name">
                                            <td>{{ item.name}}</td>
                                            <td> {{(item.size/1000)}} KB</td>
                                            <td> <i v-if="status_archivos" class="fas fa-check-circle text-success"></i>
                                                    <i v-if="!status_archivos" class="fas fa-times text-danger"></i></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" :disabled="status_archivos"
                                                 type="button" @click="deleteFile(item.name)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-btn  depressed color="primary"
                            @click="updateTarea">
                        Actualizar
                        </v-btn>
                </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                tareas: {},
                estado_tarea: [],
                file:'',
                files:[],
                data_files:[],
                ruta_archivo:[],
                status_archivos:false,


            }
        },
        created() {
            this.axios
                .get(`/api/tareas/${this.$route.params.id}`)
                .then((res) => {
                    this.tareas = res.data;
                    console.log(this.tareas);
                //this.files=this.tareas.adjunto.split(',');
                });
                this.axios.get("/api/estado-tareas/").then(response => {
                this.estado_tarea = response.data;
        });

        },
        methods: {
            processFile(event) {
                let fileList = event.target.files;
                for (const file of fileList) {
                    this.data_files.push({
                        name: file.name,
                        size: file.size,
                        file: file,
                        status:false
                    });
                    //console.log(file);
                }
                this.files=this.data_files;
                //this.files.push(this.file);
            },
            deleteFile(name) {
                let i = this.files.map(data => data.name).indexOf(name);
                this.files.splice(i, 1);
                //this.file.length=this.file.length-1;
            },
            subirArchivos(){
                console.log(this.files);
                const config = {
                    headers: { 'enctype': 'multipart/form-data' }
                }
                //console.log(this.files);
                for (const file of this.files) {
                    let formData = new FormData();
                    formData.append('file', file);
                     this.axios
                    .post(`/api/subir-archivo/`, formData,config)
                    .then((res) => {
                        //this.$router.push({ name: 'tareas' });
                        console.log(res)
                        this.ruta_archivo.push(res.data.archivo);
                        console.log(this.ruta_archivo);
                    }).catch((error)=>{
                        console.log(error);
                    });
                }
                this.status_archivos=true;
            },
            updateTarea(e) {
                e.preventDefault();
                this.tareas.adjuntos=this.ruta_archivo;
                this.tareas.estado=this.tareas.estado.id;
                console.log(this.tareas);
                this.axios
                    .patch(`/api/tareas/${this.$route.params.id}`, this.tareas)
                    .then((res) => {
                        this.$router.push({ name: 'tareas' });
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false);
            }
        }
    }
</script>
