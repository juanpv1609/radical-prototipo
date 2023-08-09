<template>
    <div>
        <v-card elevation="2" :loading="loading">
            <v-tabs dark show-arrows>
                <v-tabs-slider color="orange darken-4"></v-tabs-slider>

                <v-tab v-for="item in clientes" :key="item.id" @click="getEntregables(item)">
                    {{ item.nombre_comercial }}
                </v-tab>
            </v-tabs>
            <v-card-title>
                <v-badge :content="tareas.length" :value="tareas.length" color="green">

                    {{ cliente.nombre_comercial }}
                </v-badge>
                <v-spacer></v-spacer>
                <v-col cols="auto">
                    <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition"
                        offset-y min-width="auto">
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field v-model="dateRangeText" label="Rango de fechas" prepend-icon="mdi-calendar"
                                readonly v-bind="attrs" v-on="on" filled rounded dense single-line
                                hide-details></v-text-field>
                        </template>
                        <v-date-picker v-model="dates" range>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="getEntregables(cliente)">
                                Cancelar
                            </v-btn>
                            <v-btn text color="primary" @click="filtrarPorFechaCliente">
                                Filtrar
                            </v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-col>
                <v-col cols="auto">
                    <v-text-field v-model="search" append-icon="mdi-magnify" label="Buscar" single-line hide-details filled
                        rounded dense></v-text-field>
                </v-col>

                <v-btn-toggle mandatory>
                    <v-btn fab small :disabled="this.tareas_email.length == 0" @click="sendAlertMultiple">
                        <v-badge bottom left :content="alertas" :value="alertas" color="red">
                            <v-icon>
                                mdi-email
                            </v-icon>
                        </v-badge>
                    </v-btn>
                    <v-btn fab small :to="{
                        name: 'calendar-tareas'
                    }">
                        <v-icon>mdi-calendar</v-icon>
                    </v-btn>
                </v-btn-toggle>

            </v-card-title>

            <v-card-text>

                <v-skeleton-loader v-if="firstLoad" :loading="loading" type="table"></v-skeleton-loader>
                <v-data-table :headers="headers" :items="tareas" :search="search" v-show="!firstLoad" sort-by="fecha"
                    :footer-props="{
                        showFirstLastPage: true,
                        firstIcon: 'mdi-arrow-collapse-left',
                        lastIcon: 'mdi-arrow-collapse-right',
                        prevIcon: 'mdi-minus',
                        nextIcon: 'mdi-plus'
                    }">

                    <template v-slot:item="row">
                        <tr>
                            <td>{{ row.item.fecha }}</td>
                            <td>{{ row.item.contrato.observacion }}</td>
                            <td>{{ row.item.usuario.name }}</td>
                            <!-- <td>{{row.item.tipo.nombre}}</td> -->
                            <td>{{ row.item.descripcion }}</td>
                            <td>
                                <v-edit-dialog :return-value.sync="row.item.ticket" large persistent @save="save(row.item)"
                                    @cancel="cancel" @open="open" @close="close">
                                    <div>{{ row.item.ticket }}</div>
                                    <template v-slot:input>
                                        <div class="mt-4 title">
                                            <v-icon>mdi-ticket</v-icon> Actualizar Ticket
                                        </div>
                                        <v-text-field v-model="row.item.ticket" label="Ticket" single-line counter
                                            autofocus></v-text-field>
                                    </template>
                                </v-edit-dialog>
                            </td>

                            <td>
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
                                <v-btn :disabled="row.item.estado_tarea.id == 3" icon color="grey darken-3"
                                    @click="editTarea(row.item)">
                                    <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn icon color="warning" v-if="$store.state.user.role == 2" @click="sendMails(row.item)">
                                    <v-icon dark>mdi-email</v-icon>
                                </v-btn>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn icon v-bind="attrs" v-on="on" color="primary"
                                            @click="downloadFile(row.item.adjunto)" target="_blank"
                                            :disabled="row.item.adjunto == null || row.item.adjunto == ''">
                                            <v-icon dark>mdi-download</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{ row.item.adjunto }}</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn icon v-bind="attrs" v-on="on" color="dark"
                                            @click="historialAdjuntos(row.item.id)">
                                            <v-icon>
                                                mdi-ballot
                                            </v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Versiones del entregable</span>
                                </v-tooltip>
                            </td>
                        </tr>

                    </template>

                </v-data-table>
                <v-snackbar v-model="snack" :timeout="3000" :color="snackColor">
                    {{ snackText }}

                    <template v-slot:action="{ attrs }">
                        <v-btn v-bind="attrs" text @click="snack = false">
                            Cerrar
                        </v-btn>
                    </template>
                </v-snackbar>
            </v-card-text>
        </v-card>
        <template>
            <v-row justify="center">
                <v-dialog v-model="dialog" persistent max-width="700px">
                    <v-card elevation="2">
                        <v-card-title>Editar Entregable
                        </v-card-title>
                        <v-card-text>
                            <v-divider></v-divider>
                            <v-row dense>
                                <v-col cols="12" sm="6">
                                    <v-autocomplete :items="responsables" item-text="name" item-value="id"
                                        v-model="tarea.responsable" label="Seleccione un responsable"></v-autocomplete>
                                </v-col>
                                <v-col cols="12" sm="3">

                                    <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false"
                                        :return-value.sync="date2" transition="scale-transition" offset-y min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="tarea.fecha" label="Fecha de entrega" readonly
                                                v-bind="attrs" v-on="on"></v-text-field>
                                        </template>
                                        <v-date-picker v-model="tarea.fecha" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="menu2 = false">
                                                Cancel
                                            </v-btn>
                                            <v-btn text color="primary" @click="$refs.menu2.save(date2)">
                                                OK
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-col>
                                <v-col cols="12" sm="3">
                                    <v-autocomplete :items="estado_tarea" item-text="descripcion" item-value="id"
                                        v-model="tarea.estado" label="Estado"></v-autocomplete>
                                </v-col>
                                <v-col cols="12" sm="8">
                                    <v-autocomplete :items="tipo_tareas" item-text="nombre" item-value="id"
                                        v-model="tarea.tipo_tarea" label="Seleccione el tipo de servicio"></v-autocomplete>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <v-text-field v-model="tarea.ticket" label="Ticket ProactivaNET"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-textarea clearable clear-icon="mdi-close-circle" label="Descripción de Entregable"
                                        v-model="tarea.descripcion" rows="1"></v-textarea>
                                </v-col>


                                <!--  <v-col cols="6">
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
                        </v-col> -->
                                <v-col cols="12">
                                    <v-textarea clearable clear-icon="mdi-close-circle" label="Observaciones"
                                        v-model="tarea.observacion" rows="1"></v-textarea>

                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="error" text @click="dialog = false">
                                Cerrar
                            </v-btn>
                            <v-btn color="primary" @click="updateTarea">
                                Actualizar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>
        </template>
        <template>
            <v-row justify="center">
                <v-dialog v-model="dialog1" persistent max-width="800px">
                    <v-toolbar color="accent-4" dark flat>
                        <v-toolbar-title>Historial de Versiones del Adjunto</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="dialog1 = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-skeleton-loader v-if="firstLoad" :loading="loading" type="table"></v-skeleton-loader>
                    <v-data-table :headers="headersAdjuntos" item-key="id" :items="historial_adjuntos" >
                        <template v-slot:item="row">
                        <tr>
                            <td>{{ row.item.version }}</td>
                            <td>{{ formatDateAdjunto(row.item.created_at) }}</td>
                            <td>{{ row.item.observacion }}</td>
                            <td>{{ row.item.adjunto }}</td>
                            <td>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn icon v-bind="attrs" v-on="on" color="primary" @click="downloadFile(row.item.adjunto)">
                                            <v-icon dark>mdi-download</v-icon>
                                        </v-btn>
                                    </template>
                                <span>{{ row.item.adjunto }}</span>
                                </v-tooltip>
                            </td>
                        </tr>
                    </template>
                    </v-data-table>
                    
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
            date2: new Date().toISOString().substr(0, 10),
            menu2: false,
            tareas: [],
            loading: true,
            dialog: false,
            dialog1: false,
            search: "",
            headers: [
                { text: "Fecha entrega", value: "fecha", groupable: false },
                { text: "Proyecto", value: "contrato.observacion", groupable: false },
                { text: "Responsable", value: "usuario.name", groupable: false },
                // { text: "Tarea", value: "tipo.nombre" ,groupable: false},
                { text: "Entregable", value: "descripcion", groupable: false },
                { text: "Ticket", value: "ticket", groupable: false },
                // { text: "Adjuntos", value: "adjunto",sortable: false, filterable: false },
                { text: "Estado", value: "estado_tarea", align: 'center', sortable: false, filterable: false, groupable: false, align: 'start' },
                { text: "Acciones", value: "controls", sortable: false, groupable: false, align: 'start' }
            ],
            headersAdjuntos: [
                { text: "Versión", value: "version", groupable: false },
                { text: "Fecha de Creación", value: "created_at", groupable: false },
                { text: "Observación", value: "observacion", groupable: false },
                { text: "Adjunto", value: "adjunto", groupable: false },
                { text: "Acciones", value: "controls", sortable: false, groupable: false, align: 'start' }
            ],
            tarea: {},
            estado_tarea: [],
            files: [],
            ruta_archivo: [],
            status_archivos: false,
            loadingUpload: false,
            dates: [],
            alertas: 0,
            tareas_email: [],
            snack: false,
            snackColor: '',
            snackText: '',
            clientes: [],
            cliente: {},
            responsables: [],
            tipo_tareas: [],
            historial_adjuntos: [],
        }

    },
    computed: {
        dateRangeText() {
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
        this.axios
            .get("/api/usuarios/")
            .then(response => {
                this.responsables = response.data;
            });
        this.axios
            .get("/api/tareas-tipo/")
            .then(response => {
                this.tipo_tareas = response.data;
            });
    },
    methods: {
        save(el) {
            this.tarea.id = el.id;
            this.tarea.ticket = el.ticket;
            this.tarea.estado = 2;
            this.tarea.adjuntos = [];
            this.tarea.observacion = `${el.ticket} actualizado por: ${this.$store.state.user.name}`;
            console.log(this.tarea);
            this.loading = true;
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
        cancel() {
            this.snack = true
            this.snackColor = 'error'
            this.snackText = 'Cancelado'
        },
        open() {
            this.snack = true
            this.snackColor = 'info'
            this.snackText = 'Editar Ticket'
        },
        close() {
            console.log('Dialog closed')
        },
        historialAdjuntos(id) {
            this.dialog1 = true
            //console.log(id);
            this.axios
                .get(`/api/tareas-adjuntos/${id}`)
                .then((res) => {
                    this.historial_adjuntos = res.data;
                    //console.log(this.historial_adjuntos);
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        formatDateAdjunto(date) {
            return date.slice(0, 10);
        },
        filtrarPorFecha() {
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
        filtrarPorFechaCliente() {
            this.loading = true;
            this.axios
                .get(`/api/tareas-cliente/${this.cliente.id}/${this.dates[0]}/${this.dates[1]}`)
                .then(response => {
                    this.tareas = response.data;
                    console.log(this.tareas);
                    this.loading = false;
                    this.menu = false;
                });
        },
        limpiarFiltro() {
            this.loading = true;

            this.axios
                .get('/api/tareas')
                .then(response => {
                    this.menu = false;
                    this.dates = [];
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
            this.tarea.responsable = el.responsable;
            this.tarea.tipo_tarea = el.tipo_tarea;
            this.tarea.descripcion = el.descripcion;
            this.tarea.fecha = el.fecha;
            this.tarea.estado = el.estado;
            this.tarea.ticket = el.ticket;
            this.tarea.observacion = el.observacion;
            this.dialog = true;
        },
        downloadFile(archivo) {
            console.log(archivo);
            let arrayArchivos = archivo.split(',');
            for (const file of arrayArchivos) {
                this.axios
                    .get(`/api/get-file/${file}`)
                    .then(response => {
                        const url = response.config.baseURL + response.config.url;
                        window.open(url, '_blank');
                    }, error => {
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
        subirArchivos() {
            this.loadingUpload = true;
            console.log(this.files);
            const config = {
                headers: { 'enctype': 'multipart/form-data' }
            }
            //console.log(this.files);
            for (const file of this.files) {
                let formData = new FormData();
                formData.append('file', file);
                this.axios
                    .post(`/api/subir-archivo`, formData, config)
                    .then((res) => {
                        //this.$router.push({ name: 'tareas' });
                        console.log(res)
                        this.ruta_archivo.push(res.data.archivo);
                        console.log(this.ruta_archivo);
                    }).catch((error) => {
                        console.log(error);
                    });
            }
            this.loadingUpload = false;
            this.status_archivos = true;
        },
        updateTarea(e) {
            e.preventDefault();
            this.tarea.adjuntos=this.ruta_archivo;
            console.log(this.tarea);
            this.axios
                .patch(`/api/tareas/${this.tarea.id}`, this.tarea)
                .then((res) => {
                    this.dialog = false;
                    this.loading = false;
                    this.status_archivos = false;
                    this.snack = true
                    this.snackColor = 'success'
                    this.snackText = 'Datos Actualizados!'
                    this.axios
                        .get('/api/tareas')
                        .then(response => {
                            this.tareas = response.data;
                            console.log(this.tareas);
                            this.loading = false;
                            if (this.dates.length > 0) this.filtrarPorFecha()
                            //this.initialData();


                            this.axios.get("/api/estado-tareas/").then(response => {
                                this.estado_tarea = response.data;
                                this.axios
                                    .get("/api/usuarios/")
                                    .then(response => {
                                        this.responsables = response.data;
                                    });
                                this.axios
                                    .get("/api/tareas-tipo/")
                                    .then(response => {
                                        this.tipo_tareas = response.data;
                                    });
                            });
                        });
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false);
        },

        async sendAlertMultiple() {
            console.log(this.tareas_email);
            for (const item of this.tareas_email) {
                await this.sendMails(item);
            }
        },
        async sendMails(el) {
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
                    this.axios.get(`/api/send-mail-user/${el.id}`).then(() => {
                        this.$swal.fire({
                            title: 'Correcto',
                            text: 'Correos enviados correctamente!',
                            icon: 'success'
                        })


                    }).catch(() => (console.log('error'))).finally(() => {

                    });
                }
            })

        },
        getEntregables(cliente) {
            this.cliente = cliente
            //console.log(cliente);
            this.loading = true;
            this.axios
                .get(`/api/tareas-cliente-all/${cliente.id}`)
                .then(response => {
                    this.tareas = response.data;
                    console.log(this.tareas);
                    this.loading = false;
                    for (const item of this.tareas) {
                        if ((item.fecha_alerta == moment().format('YYYY-MM-DD'))
                            && (item.alerta_enviada == 0)
                        ) {
                            this.alertas++;
                            this.tareas_email.push(item);

                        }
                    }
                    this.loading = false;
                    this.firstLoad = false;
                });
            this.axios.get("/api/estado-tareas/").then(response => {
                this.estado_tarea = response.data;
            });
        },
        initialData() {
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
