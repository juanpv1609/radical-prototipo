<template>
<div>
    <v-card elevation="2" :loading="loading">
        <v-card-title class="d-flex justify-space-between mb-6"
            >Contratos
            <v-btn
                class="mx-2"
                fab
                dark
                small
                color="primary"
                @click="addContrato"
            >
                <v-icon dark>
                    mdi-plus
                </v-icon>
            </v-btn>
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
                :items="contratos"
                :search="search"
            >
            <template v-slot:item="row">
                <tr>
                    <td>{{row.item.id}}</td>
                    <td>{{row.item.descripcion}}</td>
                    <td>{{row.item.cliente.nombre_comercial}}</td>
                    <td>{{row.item.fecha_inicio}}</td>
                    <td>{{row.item.fecha_fin }}</td>
                    <td>{{row.item.area.nombre}}</td>
                    <td>{{row.item.solucion}}</td>
                    <td>
                        <v-btn  icon color="primary" @click="downloadFile(row.item.adjunto)" target="_blank"
                        :disabled="row.item.adjunto==null || row.item.adjunto==''">
                            <v-icon dark>mdi-download</v-icon>
                            </v-btn>
                    </td>
                    <td>
                        <v-btn  icon color="primary" @click="findTareas(row.item)">
                            <v-icon dark>mdi-eye</v-icon>
                            </v-btn>
                            <v-btn  icon color="success" :to="{
                                                name: 'contratos-tasks',
                                                params: { id: row.item.id }
                                            }">
                            <v-icon dark>mdi-plus</v-icon>
                            </v-btn>
                    </td>
                    <td>
                        <v-btn  icon color="primary" @click="editContrato(row.item)">
                            <v-icon dark>mdi-pencil</v-icon>
                            </v-btn>
                            <v-btn  icon color="warning" @click="sendMails(row.item)">
                            <v-icon dark>mdi-email</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </template>
    </v-data-table>
        </v-card-text>

        <v-card-actions> </v-card-actions>
    </v-card>
    <!-- <template>
        <v-row justify="center" >
           <v-dialog v-model="dialogTareas" max-width="600px">
               <v-card>
                   <v-card-title>
                       <span class="headline">

                       </span>
                   </v-card-title>
                   <v-card-text>
                       <v-data-table :headers="headersTareas"
                                        :items="tareas">

                       </v-data-table>
                       <template v-slot:item="row">
                        <tr>
                            <td>
                                <v-select :items="tareas"
                                v-model="frecuencias.value"
                                    label="Frecuencia" >
                                <template slot="selection" slot-scope="data">
                                    {{ data.item.descripcion }}
                                </template>
                                <template slot="item" slot-scope="data">
                                    {{ data.item.descripcion }}
                                </template>
                            </v-select>
                                {{row.item.responsable}}</td>
                            <td>{{row.item.tipo_tarea}}</td>
                            <td>{{row.item.fecha}}</td>
                            <td>{{row.item.estado_tarea.id}}</td>
                        </tr>
                       </template>
                   </v-card-text>
               </v-card>
           </v-dialog>
        </v-row>
    </template> -->
    <template>
        <v-row justify="center">
            <v-dialog v-model="dialog" persistent max-width="800px">
                <v-card>
                    <v-card-title>
                        <span class="headline">{{ titleForm }}</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="4">
                                    <v-select :items="clientes"
                                    v-model="contrato.cliente"
                                        label="Seleccione un cliente" >
                                        <template slot="selection" slot-scope="data">
                                            <!-- HTML that describe how select should render selected items -->
                                            {{ data.item.nombre_comercial }}
                                        </template>
                                        <template slot="item" slot-scope="data">
                                            <!-- HTML that describe how select should render items when the select is open -->
                                            {{ data.item.nombre_comercial }}
                                        </template>
                                    </v-select>
                                </v-col>
                                <v-col cols="4">
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
                                            v-model="contrato.fecha_inicio"
                                            label="Fecha inicial"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                        </template>
                                        <v-date-picker
                                        v-model="contrato.fecha_inicio"
                                        no-title
                                        scrollable
                                        >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="menu = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.menu.save(date)"
                                        >
                                            OK
                                        </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>
                                <v-col cols="4">
                                    <v-menu
                                        ref="menu2"
                                        v-model="menu2"
                                        :close-on-content-click="false"
                                        :return-value.sync="date2"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="contrato.fecha_fin"
                                            label="Fecha final"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                        </template>
                                        <v-date-picker
                                        v-model="contrato.fecha_fin"
                                        no-title
                                        scrollable
                                        >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="menu2 = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.menu2.save(date2)"
                                        >
                                            OK
                                        </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>
                            </v-row>
                                <v-row>

                                <v-col cols="4">
                                    <v-select :items="paises"
                                    v-model="contrato.pais"
                                        label="Seleccione un pais" >
                                        <template slot="selection" slot-scope="data">
                                            <!-- HTML that describe how select should render selected items -->
                                            {{ data.item.nombre }}
                                        </template>
                                        <template slot="item" slot-scope="data">
                                            <!-- HTML that describe how select should render items when the select is open -->
                                            {{ data.item.nombre }}
                                        </template>
                                    </v-select>
                                </v-col>
                                <v-col cols="4">
                                    <v-select :items="areas"
                                    v-model="contrato.area"
                                        label="Seleccione un area" >
                                        <template slot="selection" slot-scope="data">
                                            <!-- HTML that describe how select should render selected items -->
                                            {{ data.item.nombre }}
                                        </template>
                                        <template slot="item" slot-scope="data">
                                            <!-- HTML that describe how select should render items when the select is open -->
                                            {{ data.item.nombre }}
                                        </template>
                                    </v-select>
                                </v-col>
                                <v-col cols="4">
                                    <v-text-field
                                        v-model="contrato.solucion"
                                        label="Solucion"

                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="4">
                                    <v-text-field
                                        v-model="contrato.marca"
                                        label="Marca"

                                    ></v-text-field>
                                </v-col>
                                <v-col cols="8">
                                    <input-tag v-model="correos"
                                     placeholder="Ingrese una direccion de correo"
                                     class="form-control form-control-lg" validate="email" ></input-tag>
                                </v-col>



                            </v-row>
                            <v-row>
                                <v-col cols="8">
                                    <v-file-input
                                small-chips
                                multiple
                                v-model="files"
                                label="Seleccione archivo/s"
                                :disabled="status_archivos"
                                >
                                </v-file-input>
                                </v-col>
                                <v-col cols="4" class="pt-4">
                                    <v-btn  color="success" block
                                        @click="subirArchivos"
                                        :disabled="status_archivos">
                                    <span v-if="status_archivos">CORRECTO</span>
                                    <span v-else>Subir {{files.length}} Archivos</span>

                                    </v-btn>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="6">
                                    <v-textarea
                                        clearable
                                        rows="2"
                                        clear-icon="mdi-close-circle"
                                        label="Descripcion del contrato"
                                        v-model="contrato.descripcion"
                                        ></v-textarea>
                                </v-col>
                                <v-col cols="6">
                                    <v-textarea
                                        clearable
                                        rows="2"
                                        clear-icon="mdi-close-circle"
                                        v-model="contrato.observacion"
                                        label="Observaciones"
                                        ></v-textarea>
                                     </v-col>
                            </v-row>
                        </v-container>
                        <small>*indicates required field</small>
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
                        <v-btn
                            v-if="!update"
                            color="primary"
                            text
                            @click="createContrato"
                        >
                            Guardar
                        </v-btn>
                        <v-btn
                            v-else
                            color="primary"
                            text
                            @click="updateContrato"
                        >
                            Actualizar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>
    </template>
    <template>
        <div
            class="modal fade"
            id="exampleModal2"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-xl modal-dialog-scrollable"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Tareas Registradas
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div
                            class="table-responsive overflow-auto "
                            v-bind:style="{ heigth: '50%' }"
                            v-if="tareas.length > 0"
                        >
                            <table class="table table-sm table-bordered" >
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width:20%">Responsable</th>
                                        <th style="width:20%">Tarea</th>
                                        <th>Entragable</th>
                                        <th style="width:10%">Fecha</th>
                                        <th style="width:10%">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="value in tareas"
                                        v-bind:key="value.id"
                                    >
                                        <td>
                                            <select
                                                v-model="value.responsable"
                                                class="form-control form-control-sm"
                                            >
                                                <option
                                                    v-for="item in responsables"
                                                    v-bind:key="item.id"
                                                    v-bind:value="item.id"
                                                >
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <select
                                                v-model="value.tipo_tarea"
                                                class="form-control form-control-sm"
                                            >
                                                <option
                                                    v-for="item in tipo_tareas"
                                                    v-bind:key="item.id"
                                                    v-bind:value="item.id"
                                                >
                                                    {{ item.nombre }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control form-control-sm"
                                                v-model="value.descripcion"
                                            />
                                        </td>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control form-control-sm"
                                                v-model="value.fecha"
                                            />
                                        </td>
                                        <td>
                                            <span
                                                v-if="
                                                    value.estado_tarea.id == 1
                                                "
                                                class="badge badge-warning"
                                            >
                                                {{
                                                    value.estado_tarea
                                                        .descripcion
                                                }}</span
                                            >
                                            <span
                                                v-else-if="
                                                    value.estado_tarea.id == 2
                                                "
                                                class="badge badge-success"
                                            >
                                                {{
                                                    value.estado_tarea
                                                        .descripcion
                                                }}</span
                                            >
                                            <span
                                                v-else-if="
                                                    value.estado_tarea.id == 3
                                                "
                                                class="badge badge-danger"
                                            >
                                                {{
                                                    value.estado_tarea
                                                        .descripcion
                                                }}</span
                                            >
                                            <span
                                                v-else
                                                class="badge badge-info"
                                            >
                                                {{
                                                    value.estado_tarea
                                                        .descripcion
                                                }}</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                            <p v-else class="alert alert-info">No se encontraron resultados :(</p>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between">
                            <v-btn
                            color="error"
                            text
                            data-dismiss="modal"
                        >
                            Cerrar
                        </v-btn>
                        <v-btn
                            color="primary"
                            text
                           @click="updateTareas"
                                v-if="tareas.length>0"
                        >
                            Actualizar
                        </v-btn>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>


</template>

<script>
import $ from "jquery";
export default {
    data() {
        return {
            contratos: [],
            correos:[],
            clientes: {},
            paises: {},
            areas: {},
            frecuencias: {},
            responsables: [],
            tipo_tareas: [],
            tareas: {},
            contrato: {},
             dialog: false,
             dialogTareas: false,
                update: false,
                cliente: {},
                loading: true,
                titleForm: null,
                search: "",
                headers: [
                { text: "ID", value: "id" },
                { text: "Descripcion", value: "descripcion" },
                { text: "Cliente", value: "cliente.nombre_comercial" },
                { text: "Fecha inicio", value: "fecha_inicio" },
                { text: "Fecha fin", value: "fecha_fin" },
                { text: "Area", value: "area" },
                { text: "Solucion", value: "solucion" },
                { text: "Adjunto", value: "adjunto" },
                { text: "Tareas", value: "" },
                { text: "Acciones", value: "controls", sortable: false }
            ],
            headersTareas: [
                { text: "Responsable", value: "responsable" },
                { text: "Tipo", value: "tipo_tarea" },
                { text: "Fecha", value: "fecha" },
                { text: "Estado", value: "estado_tarea" },
            ],
            date: new Date().toISOString().substr(0, 10),
            menu: false,
            date2: new Date().toISOString().substr(0, 10),
            menu2: false,
            files:[],
            ruta_archivo:[],
            status_archivos:false,
        };
    },
    created() {
        this.axios.get("/api/contratos/").then(response => {
            this.contratos = response.data;
            this.loading = false;
            //console.log(response.data);
        });
        this.axios.get("/api/clientes/").then(response => {
            this.clientes = response.data;
            //console.log('clientes'+response.data);
        });
        this.axios.get("/api/paises/").then(response => {
            this.paises = response.data;
            //console.log(response.data);
        });
        this.axios.get("/api/areas/").then(response => {
            this.areas = response.data;
            //console.log(response.data);
        });
        this.axios
            .get("/api/usuarios/")
            .then(response => {
                this.responsables = response.data;
            });
        this.axios
            .get("/api/tipo-tareas/")
            .then(response => {
                this.tipo_tareas = response.data;
            });
        this.axios
            .get("/api/frecuencias/")
            .then(response => {
                this.frecuencias = response.data;
                //console.log(response.data);
            });
    },
    methods: {
        addContrato() {

                this.titleForm = "Nuevo Contrato";
                this.contrato = {};
                this.correos = [];
                this.update = false;
                this.dialog = true;
            },
            editContrato(el) {
                this.titleForm = "Editar Contrato";
                this.update = true;
                console.log(el);
                this.contrato.id = el.id;
                this.contrato.descripcion = el.descripcion;
                this.contrato.cliente = el.cliente_id;
                this.contrato.fecha_inicio = el.fecha_inicio;
                this.contrato.fecha_fin = el.fecha_fin;
                this.contrato.area = el.area;
                this.contrato.pais = el.pais;
                this.contrato.solucion = el.solucion;
                this.contrato.marca = el.marca;
                this.contrato.observacion = el.observacion;
                this.correos=el.correos.split(",");
                console.log(this.correos);
                this.dialog = true;
            },
            createContrato() {
                this.loading = true;
                this.contrato.cliente=this.contrato.cliente.id;
                this.contrato.area=this.contrato.area.id;
                this.contrato.pais=this.contrato.pais.id;
                this.contrato.correos=this.correos;
                this.contrato.adjuntos=this.ruta_archivo;

               console.log(this.contrato);
             this.axios
                    .post('/api/contratos', this.contrato)
                    .then(response => {
                        this.dialog = false;
                        this.loading = false;
                        this.refresh();
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
        },
        updateContrato() {
            this.loading = true;
            this.contrato.cliente=this.contrato.cliente.id;
            this.contrato.area=this.contrato.area.id;
            this.contrato.pais=this.contrato.pais.id;
            this.contrato.correos=this.correos.join(',');
            this.contrato.adjuntos=this.ruta_archivo;

            this.axios
                    .patch(`/api/contratos/${this.contrato.id}`, this.contrato)
                    .then(response => {
                        this.dialog = false;
                        this.loading = false;
                        this.refresh();
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
        },
        findTareas(el) {
            console.log(el);
            this.axios.get(`/api/contrato-tareas/${el.id}`).then(res => {
                //this.contratos = res.data;
                console.log(res.data);
                this.tareas = res.data;
                $("#exampleModal2").modal("show");
                //this.dialogTareas=true;
            });
        },
        updateTareas() {
            console.log(this.tareas);
            this.contrato.tareas = this.tareas;

            this.axios
                .post(`/api/tareasAll/`, this.contrato)
                .then(() => {
                    this.$toasted.success("Tareas actualizadas correctamente");

                    $("#exampleModal2").modal("hide");
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
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
                    .post(`/api/subir-archivo`, formData,config)
                    .then((res) => {
                        //this.$router.push({ name: 'tareas' });
                        //console.log(res)
                        this.ruta_archivo.push(res.data.archivo);
                       // console.log(this.ruta_archivo);
                    }).catch((error)=>{
                        console.log(error);
                    });
                }
                        this.status_archivos=true;
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
        deleteClient(id) {
            this.axios.delete(`/api/contratos/${id}`).then(response => {
                let i = this.contratos.map(data => data.id).indexOf(id);
                this.contratos.splice(i, 1);
            });
        },
        async sendMails(el){
            //this.correos='';
           await this.axios
            .get(`/api/contratos/${el.id}`)
            .then((res) => {
                console.log(res.data);
                this.correos = res.data.correos.replace(',','<br>')
            });
            await this.$swal.fire({
                title: 'Esta seguro?',
                html: `Se enviara un correo a las siguientes direcciones:\n${this.correos}`,
                icon: 'question',
                showConfirmButton: true,
                showCancelButton: true

                }).then(res => {
                if (res.value) {
                    this.$swal.fire({
                        title: 'Espere',
                        text: 'Enviando correos...',
                        icon: 'info',
                        allowOutsideClick: false
                    });
                        this.$swal.showLoading();
                        this.axios.get(`/api/send-mails-client/${el.id}`).then(()=>{
                            this.$swal.fire({
                                title: 'Correcto',
                                text: 'Correos enviados correctamente!',
                                icon: 'success'
                                })


                        }).catch(()=>(console.log('error'))).finally(()=>{

                        });
                    }
                })

        },
        refresh(){
            this.axios.get("/api/contratos/").then(response => {
                                this.contratos = response.data;
                                //console.log(response.data);
                            });
                            this.axios.get("/api/clientes/").then(response => {
                                this.clientes = response.data;
                                //console.log('clientes'+response.data);
                            });
                            this.axios.get("/api/paises/").then(response => {
                                this.paises = response.data;
                                //console.log(response.data);
                            });
                            this.axios.get("/api/areas/").then(response => {
                                this.areas = response.data;
                                //console.log(response.data);
                            });
                            this.axios
                                .get("/api/frecuencias/")
                                .then(response => {
                                    this.frecuencias = response.data;
                                    //console.log(response.data);
                                });
        }
    }
};
</script>
