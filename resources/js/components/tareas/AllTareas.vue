<template>
<div>
    <v-card elevation="2" :loading="loading">
        <v-tabs
      dark
      show-arrows
    >
      <v-tabs-slider color="orange darken-4"></v-tabs-slider>

      <v-tab
        v-for="item in clientes"
        :key="item.id"
        @click="getEntregables(item)"
      >
        {{ item.nombre_comercial }}
      </v-tab>
    </v-tabs>
        <v-card-title
          >
           <v-badge
                :content="tareas.length"
                :value="tareas.length"
                color="green"

            >

            {{ nombreCliente }}
            </v-badge>
          <v-spacer></v-spacer>
          <v-col cols="auto">
                <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                >
                <template v-slot:activator="{ on, attrs }">
                <v-text-field
                    v-model="dateRangeText"
                    label="Rango de fechas"
                    prepend-icon="mdi-calendar"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                    filled
                    rounded
                    dense
                    single-line
              hide-details
                ></v-text-field>
                </template>
                <v-date-picker
                v-model="dates"
                range
                >
                <v-spacer></v-spacer>
                <v-btn
                    text
                    color="primary"
                    @click="limpiarFiltro"
                >
                    Cancelar
                </v-btn>
                <v-btn
                    text
                    color="primary"
                    @click="filtrarPorFecha"
                >
                    Filtrar
                </v-btn>
                </v-date-picker>
                </v-menu>
            </v-col>
          <v-col cols="auto">
              <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Buscar"
              single-line
              hide-details
              filled
                rounded
                dense
          ></v-text-field>
          </v-col>

          <v-btn-toggle
                mandatory
                >
            <v-btn

                    fab
                    small
                    :disabled="this.tareas_email.length==0"
                    @click="sendAlertMultiple"
                >
                    <v-badge
                        bottom
                        left
                        :content="alertas"
                        :value="alertas"
                        color="red"

                    >
                        <v-icon >
                        mdi-email
                        </v-icon>
                    </v-badge>
                </v-btn>
                <v-btn
                    fab
                    small :to="{
                                    name: 'calendar-tareas'}">
                    <v-icon >mdi-calendar</v-icon>
                </v-btn>
            </v-btn-toggle>

        </v-card-title>

        <v-card-text>

            <v-skeleton-loader v-if="firstLoad" :loading="loading" type="table"></v-skeleton-loader>
            <v-data-table
                :headers="headers"
                :items="tareas"
                :search="search"
                v-show="!firstLoad"
                sort-by="fecha"
            >

            <template v-slot:item="row">
                <tr >
                    <td>{{row.item.fecha}}</td>
                    <td>{{row.item.usuario.name}}</td>
                    <!-- <td>{{row.item.tipo.nombre}}</td> -->
                    <td>{{row.item.descripcion}}</td>
                    <td>
                        <v-edit-dialog
                            :return-value.sync="row.item.ticket"
                            large
                            persistent
                            @save="save(row.item)"
                            @cancel="cancel"
                            @open="open"
                            @close="close"
                            >
                            <div>{{ row.item.ticket }}</div>
                            <template v-slot:input>
                                <div class="mt-4 title">
                                <v-icon>mdi-ticket</v-icon> Actualizar Ticket
                                </div>
                                <v-text-field
                                v-model="row.item.ticket"
                                label="Ticket"
                                single-line

                                counter
                                autofocus
                                ></v-text-field>
                            </template>
                            </v-edit-dialog>
                    </td>

                    <td >
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon v-bind="attrs" v-on="on" :color="row.item.estado_tarea.color">
                                    mdi-circle
                                </v-icon>
                            </template>
                                <span>{{ row.item.estado_tarea.descripcion }}</span>
                        </v-tooltip>
                    </td>
                    <td>
                        <v-btn :disabled="row.item.estado_tarea.id==3"  icon color="grey darken-3"
                        @click="editTarea(row.item)">
                        <v-icon dark>mdi-pencil</v-icon>
                        </v-btn>
                         <v-btn  icon color="warning" v-if="$store.state.user.role==2" @click="sendMails(row.item)">
                            <v-icon dark>mdi-email</v-icon>
                        </v-btn>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                        <v-btn  icon v-bind="attrs"
                                     v-on="on" color="primary" @click="downloadFile(row.item.adjunto)" target="_blank"
                        :disabled="row.item.adjunto==null || row.item.adjunto==''">
                            <v-icon dark>mdi-download</v-icon>
                            </v-btn>
                            </template>
                            <span>{{ row.item.adjunto }}</span>
                        </v-tooltip>
                    </td>
                </tr>

            </template>

            </v-data-table>
            <v-snackbar
                v-model="snack"
                :timeout="3000"
                :color="snackColor"
                >
                {{ snackText }}

                <template v-slot:action="{ attrs }">
                    <v-btn
                    v-bind="attrs"
                    text
                    @click="snack = false"
                    >
                    Cerrar
                    </v-btn>
                </template>
                </v-snackbar>
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
                    <v-btn   color="primary"
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
                firstLoad: true,
                date: new Date().toISOString().substr(0, 10),
            menu: false,
                tareas: [],
                loading: true,
                dialog: false,
                search: "",
                headers: [
                    { text: "Fecha entrega", value: "fecha" ,groupable: false},
                    { text: "Responsable", value: "usuario.name" ,groupable: false},
                    // { text: "Tarea", value: "tipo.nombre" ,groupable: false},
                    { text: "Entregable", value: "descripcion" ,groupable: false},
                    { text: "Ticket", value: "ticket" ,groupable: false},
                   // { text: "Adjuntos", value: "adjunto",sortable: false, filterable: false },
                    { text: "Estado", value: "estado_tarea",align:'center',sortable: false, filterable: false ,groupable: false,align: 'start'},
                    { text: "Acciones", value: "controls", sortable: false ,groupable: false,align: 'start'}
            ],
            tarea: {},
                estado_tarea: [],
                files:[],
                ruta_archivo:[],
                status_archivos:false,
            loadingUpload: false,
            dates: [],
            alertas:0,
            tareas_email: [],
            snack: false,
        snackColor: '',
        snackText: '',
        clientes: [],
        nombreCliente:null
            }

        },
        computed: {
            dateRangeText () {
                return this.dates.join(' ~ ')
            },
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
            this.initialData();
        },
        methods: {
            save (el) {
                this.tarea.id=el.id;
                this.tarea.ticket=el.ticket;
                this.tarea.estado=2;
                this.tarea.adjuntos=[];
                this.tarea.observacion=`${el.ticket} actualizado por: ${this.$store.state.user.name}`;
                console.log(this.tarea);
                this.loading=true;
                 this.axios
                    .patch(`/api/tareas/${this.tarea.id}`, this.tarea)
                    .then((res) => {
                        this.initialData();
                        this.snack = true
                        this.snackColor = 'success'
                        this.snackText = 'Datos guardados'

                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false);
            },
            cancel () {
                this.snack = true
                this.snackColor = 'error'
                this.snackText = 'Cancelado'
            },
            open () {
                this.snack = true
                this.snackColor = 'info'
                this.snackText = 'Editar Ticket'
            },
            close () {
                console.log('Dialog closed')
            },
            filtrarPorFecha(){
                 this.loading = true;
                this.axios
                .get(`/api/tareas/${this.dates[0]}/${this.dates[1]}`)
                .then(response => {
                    this.tareas = response.data;
                    console.log(this.tareas);
                    this.loading = false;
                     this.menu = false;
                });
            },
            limpiarFiltro(){
                this.loading = true;

                this.axios
                .get('/api/tareas')
                .then(response => {
                    this.menu = false;
                this.dates=[];
                    this.tareas = response.data;
                    console.log(this.tareas);
                    this.loading = false;
                });
            },
            editTarea(el) {
                console.log(el);
                this.files = [];
                this.ruta_archivo = [];
                this.status_archivos = false;
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
                        this.status_archivos = false;

                        this.axios
                        .get('/api/tareas')
                        .then(response => {
                            this.tareas = response.data;
                            console.log(this.tareas);
                            this.loading = false;
                            if (this.dates.length>0) this.filtrarPorFecha()

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
            },
            async sendAlertMultiple(){
                console.log(this.tareas_email);
                for (const item of this.tareas_email) {
                    await this.sendMails(item);
                }
            },
             async sendMails(el){
                 console.log(el);
             await this.$swal.fire({
                title: 'Esta seguro?',
                html: `Se enviara un correo a la siguiente dirección:\n${el.usuario.email}\n
                Con copia a: ${el.correos_alerta}`,
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
                        this.axios.get(`/api/send-mail-user/${el.id}`).then(()=>{
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
        getEntregables(cliente){
            this.nombreCliente=cliente.nombre_comercial
            //console.log(cliente);
            this.loading=true;
             this.axios
                .get(`/api/tareas-cliente/${cliente.id}`)
                .then(response => {
                    this.tareas = response.data;
                    //console.log(this.tareas);
                    this.loading = false;
                    for (const item of this.tareas) {
                        if ((item.fecha_alerta==moment().format('YYYY-MM-DD'))
                        && (item.alerta_enviada==0)
                        ) {
                            this.alertas++;
                            this.tareas_email.push(item);

                        }
                    }
                    this.loading=false;
                    this.firstLoad=false;
                });
                    this.axios.get("/api/estado-tareas/").then(response => {
                    this.estado_tarea = response.data;
                });
        },
        initialData(){
            this.axios
                .get('/api/clientes')
                .then(response => {
                    this.clientes = response.data;
                    //console.log(this.clientes);
                    this.getEntregables(this.clientes[0]);
                });
                //this.getEntregables(this.clientes[0].id)

             /* this.axios
                .get('/api/tareas')
                .then(response => {
                    this.tareas = response.data;
                    //console.log(this.tareas);
                    this.loading = false;
                    for (const item of this.tareas) {
                        if ((item.fecha_alerta==moment().format('YYYY-MM-DD'))
                        && (item.alerta_enviada==0)
                        ) {
                            this.alertas++;
                            this.tareas_email.push(item);

                        }
                    }
                    this.loading=false;
                    this.firstLoad=false;
                });
                    this.axios.get("/api/estado-tareas/").then(response => {
                    this.estado_tarea = response.data;
                }); */

        }

       }
    }
</script>
