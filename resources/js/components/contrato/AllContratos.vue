<template>
    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title>
                <v-badge :content="contratos.length" :value="contratos.length" color="green">
                    Contratos
                </v-badge>
                <v-spacer></v-spacer>
                <v-col cols="auto">
                    <v-text-field v-model="search" append-icon="mdi-magnify" label="Buscar" single-line hide-details filled
                        rounded dense></v-text-field>
                </v-col>

                <v-btn class="mx-2" fab dark small color="primary" :disabled="$store.state.user.role == 1"
                    @click="addContrato">
                    <v-icon dark>
                        mdi-plus
                    </v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text>
                <v-data-table :headers="headers" :items="contratos" :search="search" :footer-props="{
                    showFirstLastPage: true,
                    firstIcon: 'mdi-arrow-collapse-left',
                    lastIcon: 'mdi-arrow-collapse-right',
                    prevIcon: 'mdi-minus',
                    nextIcon: 'mdi-plus'
                }">
                    <template v-slot:item="row">
                        <tr>
                            <td>{{ row.item.observacion }}</td>
                            <td>{{ row.item.cliente.nombre_comercial }}</td>
                            <td>{{ row.item.fecha_inicio }}</td>
                            <td>{{ row.item.fecha_fin }}</td>
                            <td>{{ row.item.area.nombre }}</td>
                            <td>
                                <v-chip small label :color="row.item.estado_contrato.color">
                                    {{ row.item.estado_contrato.descripcion }}
                                </v-chip>
                            </td>
                            <td>
                                <v-btn icon small elevation="2" color="orange darken-4"
                                    :disabled="$store.state.user.role == 1" @click="findTareas(row.item)"
                                    title="Clic para ver los entregables">
                                    {{ row.item.tarea.length }}
                                </v-btn>
                            </td>
                            <td>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn icon v-bind="attrs" v-on="on" color="dark"
                                            @click="downloadFile(row.item.adjunto)" target="_blank"
                                            :disabled="row.item.adjunto == null || row.item.adjunto == ''">
                                            <v-icon dark>mdi-download</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Descargar {{ row.item.adjunto }}</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn v-bind="attrs" v-on="on" icon color="dark" :to="{
                                            name: 'contratos-tasks',
                                            params: { id: row.item.id }
                                        }" :disabled="$store.state.user.role == 1">
                                            <v-icon dark>mdi-plus-circle</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Agregar entregables</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn v-bind="attrs" v-on="on" icon color="dark"
                                            :disabled="$store.state.user.role == 1" @click="editContrato(row.item)">
                                            <v-icon dark>mdi-pencil</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>Editar contrato</span>
                                </v-tooltip>
                                <!-- <v-btn  icon color="warning" @click="sendMails(row.item)">
                            <v-icon dark>mdi-email</v-icon>
                        </v-btn> -->
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
        <template>
            <v-row justify="center">
                <v-dialog v-model="dialog" persistent max-width="800px">
                    <v-card>
                        <v-toolbar color="accent-4" dark flat>
                            <v-toolbar-title>{{ titleForm }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn icon @click="dialog = false; contrato = {}">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                            <template v-slot:extension>
                                <v-tabs v-model="tabs" fixed-tabs>
                                    <v-tabs-slider color="orange"></v-tabs-slider>
                                    <v-tab href="#tab-1">Datos Principales</v-tab>
                                    <v-tab href="#tab-2">Servicios</v-tab>
                                    <!-- <v-tab href="#tab-3">Entregables</v-tab> -->
                                    <v-tab href="#tab-4">Adjuntos</v-tab>
                                    <v-tab href="#tab-5">Destinatarios-CC</v-tab>
                                    <v-tab href="#tab-6">Estructura del Informe</v-tab>
                                </v-tabs>
                            </template>
                        </v-toolbar>
                        <v-card-text>
                            <v-tabs-items v-model="tabs">
                                <v-tab-item :value="'tab-1'">
                                    <br>
                                    <v-row>
                                        <br>
                                        <v-col cols="4">
                                            <v-autocomplete :items="clientes" item-text="nombre_comercial" item-value="id"
                                                v-model="contrato.cliente" label="Seleccione un cliente"
                                                return-object>
                                            </v-autocomplete>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-menu ref="menu" v-model="menu" :close-on-content-click="false"
                                                :return-value.sync="date" transition="scale-transition" offset-y
                                                min-width="auto">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field v-model="contrato.fecha_inicio" label="Fecha inicial"
                                                        readonly v-bind="attrs" v-on="on">
                                                    </v-text-field>
                                                </template>
                                                <v-date-picker v-model="contrato.fecha_inicio" no-title scrollable>
                                                    <v-spacer>
                                                    </v-spacer>
                                                    <v-btn text color="primary" @click="menu = false">
                                                        Cancel
                                                    </v-btn>
                                                    <v-btn text color="primary" @click="$refs.menu.save(date)">
                                                        OK
                                                    </v-btn>
                                                </v-date-picker>
                                            </v-menu>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false"
                                                :return-value.sync="date2" transition="scale-transition" offset-y
                                                min-width="auto">
                                                <template v-slot:activator="{ on, attrs }">
                                                    <v-text-field v-model="contrato.fecha_fin" label="Fecha final" readonly
                                                        v-bind="attrs" v-on="on"></v-text-field>
                                                </template>
                                                <v-date-picker v-model="contrato.fecha_fin" no-title scrollable>
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
                                    </v-row>
                                    <v-row dense>
                                        <v-col cols="4">
                                            <v-select :items="paises" v-model="contrato.pais" label="Seleccione un pais">
                                                <template slot="selection" slot-scope="data">
                                                    <!-- HTML that describe how select should render selected items -->
                                                    {{ data.item.nombre }}
                                                </template>
                                                <template slot="item" slot-scope="data">
                                                    <!-- HTML that describe how select should render items when the select is open -->
                                                    ({{ data.item.abreviatura }}) {{ data.item.nombre }}
                                                </template>
                                            </v-select>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-select :items="areas" v-model="contrato.area" label="Seleccione un área">
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
                                            <v-text-field v-model="contrato.solucion"
                                                label="Solución o Herramienta"></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row dense>
                                        <v-col cols="4">
                                            <v-text-field v-model="contrato.marca"
                                                label="Marca o Fabricante"></v-text-field>
                                        </v-col>
                                        <v-col cols="8">
                                            <v-combobox v-model="correos" :items="contrato.correos" hide-selected
                                                hint="Ingrese una o varias direcciones de correo de contacto Enter o TAB "
                                                label="Direcciones de correo" multiple persistent-hint small-chips
                                                deletable-chips :delimiters="[',']" @change="delimitCorreos">
                                            </v-combobox>
                                        </v-col>
                                    </v-row>
                                    <v-row dense>
                                        <v-col cols="6">
                                            <v-textarea clearable rows="2" clear-icon="mdi-close-circle"
                                                label="Identificador del Contrato"
                                                v-model="contrato.descripcion"></v-textarea>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-textarea clearable rows="2" clear-icon="mdi-close-circle"
                                                v-model="contrato.observacion"
                                                label="Descripción del contrato"></v-textarea>
                                        </v-col>
                                    </v-row>
                                </v-tab-item>
                                <v-tab-item :value="'tab-2'">
                                    <v-card>
                                        <v-card-title>Seleccione el/los servicios que se incluyen en el contrato
                                        </v-card-title>
                                        <v-card-text>
                                            <v-data-table v-model="selectedServicios" :headers="headersServicios"
                                                :items="servicios" item-key="id" show-select :items-per-page="5"
                                                :footer-props="{
                                                    showFirstLastPage: true,
                                                    firstIcon: 'mdi-arrow-collapse-left',
                                                    lastIcon: 'mdi-arrow-collapse-right',
                                                    prevIcon: 'mdi-minus',
                                                    nextIcon: 'mdi-plus'
                                                }">

                                            </v-data-table>
                                        </v-card-text>
                                    </v-card>
                                </v-tab-item>
                                <v-tab-item :value="'tab-3'">
                                </v-tab-item>
                                <v-tab-item :value="'tab-4'">
                                    <v-card>
                                        <v-card-title>Suba archivos relacionados al contrato
                                        </v-card-title>
                                        <v-card-text>
                                            <v-row>
                                                <v-col cols="12">
                                                    <v-file-input show-size small-chips multiple counter v-model="files"
                                                        label="Seleccione archivo/s (Contrato, kickoff, cronograma, etc)"
                                                        :disabled="status_archivos"
                                                        hint="Seleccione los archivos y luego haga clic en SUBIR ARCHIVOS"
                                                        persistent-hint>
                                                    </v-file-input>
                                                </v-col>
                                                <v-col cols="12">
                                                    <v-btn color="success" block @click="subirArchivos"
                                                        :loading="loadingUpload" :disabled="status_archivos">
                                                        <span v-if="status_archivos">CORRECTO</span>
                                                        <span v-else>Subir {{ files.length }} Archivos</span>

                                                    </v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-card-text>
                                    </v-card>
                                </v-tab-item>
                                <v-tab-item :value="'tab-5'">
                                    <v-card>
                                        <v-card-title>Seleccione los destinatarios de alerta de fin de contrato
                                        </v-card-title>
                                        <v-card-text>
                                            <v-data-table v-model="selectedDestinatarios" :headers="headersDestinatarios"
                                                :items="destinatarios" item-key="id" show-select :items-per-page="5"
                                                :footer-props="{
                                                    showFirstLastPage: true,
                                                    firstIcon: 'mdi-arrow-collapse-left',
                                                    lastIcon: 'mdi-arrow-collapse-right',
                                                    prevIcon: 'mdi-minus',
                                                    nextIcon: 'mdi-plus'
                                                }">

                                            </v-data-table>
                                        </v-card-text>
                                    </v-card>
                                </v-tab-item>
                                <v-tab-item :value="'tab-6'">
                                    <br>
                                    <v-row dense>
                                        <v-col cols="2"></v-col>
                                        <v-col cols="8">
                                            <v-combobox clearable rows="7" clear-icon="mdi-close-circle"
                                                label="Elementos que debe contener el entregable (Separados por comas)"
                                                multiple persistent-hint small-chips
                                                deletable-chips :delimiters="[',']" @change="delimitEstructuraInforme"
                                                v-model="contrato.estructura_informe">
                                            </v-combobox>
                                        </v-col>
                                    </v-row>
                                </v-tab-item>
                            </v-tabs-items>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="error" text @click="dialog = false">
                                Cerrar
                            </v-btn>
                            <v-btn v-if="!update" color="primary" text @click="createContrato">
                                Guardar
                            </v-btn>
                            <v-btn v-else color="primary" text @click="updateContrato">
                                Actualizar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-row>
        </template>
        <template>
            <v-dialog v-model="dialogTareas" persistent fullscreen hide-overlay transition="dialog-bottom-transition"
                :loading="loading">
                <v-card>
                    <v-toolbar dark color="primary">
                        <v-btn icon dark @click="dialogTareas = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title>{{ titleTareas }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark text @click="updateTareas" v-if="tareas.length > 0">
                                Actualizar
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-card-text>
                        <br>
                        <v-data-table :headers="headersTareas" :items="tareas" class="elevation-2" :footer-props="{
                            showFirstLastPage: true,
                            firstIcon: 'mdi-arrow-collapse-left',
                            lastIcon: 'mdi-arrow-collapse-right',
                            prevIcon: 'mdi-minus',
                            nextIcon: 'mdi-plus'
                        }">
                            <template v-slot:item="{ item }">
                                <tr>
                                    <td style="width:20%">
                                        <select v-model="item.responsable" class="custom-select">
                                            <option v-for="item in responsables" v-bind:key="item.id"
                                                v-bind:value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </td>
                                    <td style="width:24%">
                                        <select v-model="item.tipo_tarea" class="custom-select">
                                            <option v-for="item in tipo_tareas" v-bind:key="item.id" v-bind:value="item.id">
                                                {{ item.nombre }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <textarea class="form-control form-control-sm" v-model="item.descripcion" rows="1">
                                        </textarea>
                                    </td>
                                    <td style="width:15%">
                                        <input type="date" class="form-control" v-model="item.fecha" />
                                    </td>
                                    <th style="width:10%">
                                        <v-tooltip right>
                                            <template v-slot:activator="{ on, attrs }">
                                                <v-icon v-bind="attrs" v-on="on" :color="item.estado_tarea.color">
                                                    mdi-circle
                                                </v-icon>
                                            </template>
                                            <span>{{ item.estado_tarea.descripcion }}</span>
                                        </v-tooltip>
                                    </th>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="red" @click="dialogTareas = false">
                            Cerrar
                        </v-btn>
                        <v-btn color="blue" @click="updateTareas" v-if="tareas.length > 0">
                            Actualizar
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>
    </div>
</template>

<script>
import $ from "jquery";
export default {
    data() {
        return {
            tabs: null,
            titleTareas: "",
            titleContrato: "",
            loadingUpload: false,
            contratos: [],
            correos: [],
            estructura_informe: [],
            clientes: {},
            paises: {},
            areas: {},
            frecuencias: {},
            responsables: [],
            tipo_tareas: [],
            tareas: [],
            contrato: {},
            dialog: false,
            dialogTareas: false,
            update: false,
            cliente: {},
            loading: true,
            titleForm: null,
            search: "",
            headers: [
                { text: "Descripcion", value: "descripcion" },
                { text: "Cliente", value: "cliente.nombre_comercial" },
                { text: "Fecha inicio", value: "fecha_inicio" },
                { text: "Fecha fin", value: "fecha_fin" },
                { text: "Servicio", value: "area" },
                { text: "Estado", value: "estado", sortable: false },
                { text: "Entregables", value: "tarea", sortable: true },
                { text: "Acciones", value: "controls", sortable: false }
            ],
            searchTareas: "",
            headersTareas: [
                { text: "Responsable", value: "responsable" },
                { text: "Tarea", value: "tipo_tarea" },
                { text: "Entregable", value: "entregable" },
                { text: "Fecha", value: "fecha" },
                { text: "Estado", value: "estado_tarea" },
            ],
            headersServicios: [
                { text: "Nombre", value: "nombre" },
                { text: "Descripción", value: "descripcion" },
            ],
            headersDestinatarios: [
                { text: "Nombre", value: "name" },
                { text: "Correo", value: "email" },
            ],
            date: new Date().toISOString().substr(0, 10),
            menu: false,
            date2: new Date().toISOString().substr(0, 10),
            menu2: false,
            files: [],
            ruta_archivo: [],
            status_archivos: false,
            servicios: [],
            selectedServicios: [],
            destinatarios: [],
            selectedDestinatarios: [],
        };
    },
    created() {
        this.axios.get("/api/contratos/").then(response => {
            this.contratos = response.data;
            this.loading = false;
            console.log(response.data);
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
        this.axios.get("/api/servicios/").then(response => {
            this.servicios = response.data;
            console.log(response.data);

        });

        this.axios.get("/api/destinatarios/").then(response => {
            this.destinatarios = response.data;
            console.log(response.data);

        })
    },
    computed: {
        likesAllServicios() {
            return this.selectedServicios.length === this.servicios.length
        },
        likesSomeServicios() {
            return this.selectedServicios.length > 0 && !this.likesAllServicios
        },
        likeAllDestinatarios() {
            return this.selectedDestinatarios.length === this.destinatarios.length
        },
        likeSomeDestinatarios() {
            return this.selectedDestinatarios.length > 0 && !this.likeAllDestinatarios
        },
        icon() {
            if (this.likesAllServicios) return 'mdi-close-box'
            if (this.likeAllDestinatarios) return 'mdi-close-box'
            if (this.likesSomeServicios) return 'mdi-minus-box'
            if (this.likeSomeDestinatarios) return 'mdi-minus-box'
            return 'mdi-checkbox-blank-outline'
        },
    },
    methods: {
        toggle() {
            this.$nextTick(() => {
                if (this.likesAllServicios) {
                    this.selectedServicios = []
                } else {
                    this.selectedServicios = this.servicios.slice()
                }
                if (this.likeAllDestinatarios) {
                    this.selectedDestinatarios = []
                } else {
                    this.selectedDestinatarios = this.destinatarios.slice()
                }
            })
        },
        addContrato() {

            this.titleForm = "Nuevo Contrato";
            this.contrato = {};
            this.correos = [];
            this.estructura_informe = [];
            this.selectedServicios = [];
            this.selectedDestinatarios = [];
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
            this.contrato.estructura_informe = (el.estructura_informe) ? el.estructura_informe.split(",") : null ;
            this.correos = (el.correos) ? el.correos.split(",") : null;
            //this.contrato.correos=this.correos;
            this.selectedServicios = el.servicios
            this.selectedDestinatarios = el.destinatarios;
            console.log(this.correos);
            this.dialog = true;
        },
        createContrato() {
            this.loading = true;
            this.contrato.cliente = this.contrato.cliente.id;
            this.contrato.area = this.contrato.area.id;
            this.contrato.pais = this.contrato.pais.id;
            this.contrato.correos = this.correos;
            this.contrato.estructura_informe = this.estructura_informe;
            this.contrato.adjuntos = this.ruta_archivo;
            this.contrato.servicios = this.selectedServicios;
            this.contrato.destinatarios = this.selectedDestinatarios;

            console.log(this.contrato);
            this.axios
                .post('/api/contratos', this.contrato)
                .then(() => {
                    this.dialog = false;
                    this.loading = false;
                    this.refresh();
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },
        updateContrato() {
            this.loading = true;

            this.contrato.adjuntos = this.ruta_archivo;
            this.contrato.servicios = this.selectedServicios;
            this.contrato.destinatarios = this.selectedDestinatarios;
            console.log(this.contrato);
            this.axios
                .patch(`/api/contratos/${this.contrato.id}`, this.contrato)
                .then(() => {
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
                this.titleTareas = el.cliente.nombre_comercial;
                this.titleContrato = el.observacion;
                //$("#exampleModal2").modal("show");
                this.dialogTareas = true;
            });
        },
        updateTareas() {
            console.log(this.tareas);
            this.contrato.tareas = this.tareas;

            this.axios
                .post(`/api/tareasAll`, this.contrato)
                .then(() => {
                    this.$toasted.success("Tareas actualizadas correctamente");

                    //$("#exampleModal2").modal("hide");
                    this.dialogTareas = false;
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        async subirArchivos() {
            this.loadingUpload = true;
            console.log(this.files);
            const config = {
                headers: { 'enctype': 'multipart/form-data' }
            }
            //console.log(this.files);
            for (const file of this.files) {
                let formData = new FormData();
                formData.append('file', file);
                await this.axios
                    .post(`/api/subir-archivo`, formData, config)
                    .then((res) => {
                        //this.$router.push({ name: 'tareas' });
                        //console.log(res)
                        this.ruta_archivo.push(res.data.archivo);
                        // console.log(this.ruta_archivo);
                    }).catch((error) => {
                        console.log(error);
                    });
            }
            this.loadingUpload = false;
            this.status_archivos = true;
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
        deleteClient(id) {
            this.axios.delete(`/api/contratos/${id}`).then(response => {
                let i = this.contratos.map(data => data.id).indexOf(id);
                this.contratos.splice(i, 1);
            });
        },
        async sendMails(el) {
            //this.correos='';
            await this.axios
                .get(`/api/contratos/${el.id}`)
                .then((res) => {
                    console.log(res.data);
                    this.correos = res.data.correos.replace(',', '<br>')
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
                    this.axios.get(`/api/send-mails-client/${el.id}`).then(() => {
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
        refresh() {
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
            this.correos = [];
            this.estructura_informe = [];
            this.ruta_archivo = [];
            this.files = [];
            this.status_archivos = false;
        },
        delimitCorreos(v) {
            const reducer = (a, e) => [...a, ...e.split(/[,]+/)]
            this.correos = [...new Set(v.reduce(reducer, []))]
        },

        delimitEstructuraInforme(v) {
            const reducer = (a, e) => [...a, ...e.split(/[,]+/)]
            this.estructura_informe = [...new Set(v.reduce(reducer, []))]
        }
    }
};
</script>
