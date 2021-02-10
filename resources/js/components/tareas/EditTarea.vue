<template>
    <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Editar Tarea</h5>
            </div>
       <div class="card-body">
                <form @submit.prevent="updateTarea" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente:</label>
                            <input type="text" class="form-control" v-model="tareas.contrato.cliente.nombre_comercial" disabled >
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha:</label>
                                <input type="text" class="form-control" v-model="tareas.fecha" disabled>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo Tarea:</label>
                                <input type="text" class="form-control"  v-model="tareas.tipo.nombre" disabled>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="ticket" class="form-label">Ticket:</label>
                                <input type="text" class="form-control"  v-model="tareas.ticket" >
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                        <label for="nombre_comercial" class="form-label">Estado:</label>
                        <select
                                v-model="tareas.estado.id"
                                class="form-control form-control-sm"
                            >
                                <option
                                    v-for="item in estado_tarea"
                                    v-bind:key="item.id"
                                    v-bind:value="item.id"
                                >
                                    {{ item.descripcion }}
                                </option>
                            </select>
                        </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                        <label for="adjunto" class="form-label">Archivos Adjuntos</label>
                        <div class="input-group">
                            <input type="file" class="form-control" :disabled="status_archivos" name="file"  @change="processFile($event)" multiple >

                        </div>

                    </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="observacion" class="form-label">Observacion</label>
                                <textarea class="form-control" cols="30" rows="3" v-model="tareas.observacion"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6" v-if="files.length>0">
                            <div class="mb-3">
                                <button class="btn btn-success" type="button"
                                 @click="subirArchivos" :disabled="status_archivos">
                                Subir <strong>{{files.length}}</strong> Archivos</button>
                            </div>

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
                                            <td> <i v-if="item.status" class="fas fa-check-circle text-success"></i>
                                                    <i v-if="!item.status" class="fas fa-times text-danger"></i></td>
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
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" >Actualizar</button>
                </form>
            </div>
        </div>
</template>

<script>
    export default {
        data() {
            return {
                tareas: {},
                estado_tarea: {},
                file:'',
                files:{},
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
                    //console.log(res.data);
                });
                this.axios.get("/api/estado-tareas/").then(response => {
                this.estado_tarea = response.data;
                console.log(response.data);
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
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                //console.log(this.files);
                for (const file of this.files) {
                    let formData = new FormData();
                    formData.append('file', file.file);
                     this.axios
                    .post(`/api/subir-archivo/`, formData,config)
                    .then((res) => {
                        //this.$router.push({ name: 'tareas' });
                        file.status=true;
                        this.ruta_archivo.push(res.data.archivo);
                        console.log(this.ruta_archivo);
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
