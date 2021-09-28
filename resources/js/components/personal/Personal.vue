<template>
    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title >

                    Personal Registrado
                    <v-spacer></v-spacer>
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
                <v-btn
                    class="mx-2"
                    fab
                    dark
                    small
                    color="primary"
                    link :to="'/personal-new'"
                >
                    <v-icon dark>
                        mdi-plus
                    </v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text>
                 <v-data-table
                    :headers="headers"
                    :items="personas"
                    :search="search"
                >
                    <template v-slot:item="row">
                        <tr>
                            <td>
                                <v-avatar v-if="row.item.foto" size="40px">
                                        <img
                                            :src="`data:image/png;base64,${row.item.foto}`"
                                            alt="Foto"
                                        >
                                </v-avatar>
                                <v-avatar  v-else color="indigo">
                                    <v-icon dark >
                                        mdi-account-circle
                                    </v-icon>
                                    </v-avatar>
                            </td>
                            <td>{{ row.item.ci }}</td>
                            <td>{{ row.item.nombre }} {{ row.item.apellido }}</td>

                            <td>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn  icon small v-bind="attrs"
                                            v-on="on" >
                                            <v-icon >mdi-email</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{ row.item.email }}</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn  icon small v-bind="attrs"
                                            v-on="on" >
                                            <v-icon >mdi-phone</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{ row.item.telefono }}</span>
                                </v-tooltip>

                            </td>
                            <!-- <td>{{ row.item.telefono }}</td> -->
                            <!-- <td>{{ row.item.fecha_nacimiento }}</td> -->

                            <td>
                                <v-btn
                                    icon
                                    color="primary"
                                >
                                    <v-icon dark @click="estudios(row.item)">mdi-school</v-icon>
                                </v-btn>
                            </td>
                            <td>

                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn  small icon v-bind="attrs" title="Descargar documentos"
                                            v-on="on" color="primary" @click="downloadFile(row.item.documentos)" target="_blank"
                                            :disabled="row.item.documentos==null || row.item.documentos==''">
                                            <v-icon dark>mdi-download</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{ row.item.documentos }}</span>
                                    </v-tooltip>
                                    <v-btn
                                    :disabled="row.item.role == 2"
                                    icon small
                                    color="success" title="Méritos"
                                    @click="openDialogMeritos(row.item)"
                                >
                                    <v-icon dark>mdi-certificate</v-icon>
                                </v-btn>
                                <v-btn
                                    icon small
                                    color="orange" title="Editar"
                                    :to="{
                                                name: 'personal-edit',
                                                params: { id: row.item.id }
                                            }"
                                >
                                    <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn
                                    :disabled="row.item.role == 2"
                                    icon small
                                    color="error" title="Eliminar"
                                    @click="deletePerson(row.item)"
                                >
                                    <v-icon dark>mdi-delete</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card-text>

            <v-card-actions> </v-card-actions>
        </v-card>
        <template>
                <v-row justify="center">
                    <v-dialog v-model="dialogEstudios" persistent >
                        <v-card>
                            <v-card-title>
                                    {{ titleFormEstudios }}
                                    <v-spacer></v-spacer>
                                    <v-col cols="auto">
                                    <v-text-field
                                    v-model="searchEstudios"
                                    append-icon="mdi-magnify"
                                    label="Buscar..."
                                    single-line
                                    hide-details
                                    filled
                                    rounded
                                    dense
                                ></v-text-field></v-col>
                            </v-card-title>
                            <v-card-text>

                                <v-data-table
                                    :headers="headersEstudios"
                                    :items="persona_estudios"
                                    :search="searchEstudios"
                                >
                                    <template v-slot:item="row">
                                        <tr>
                                            <td>{{ row.item.descripcion }}</td>
                                            <td>{{ row.item.institucion }}</td>
                                            <td>{{ row.item.fecha_inicio }}</td>

                                            <td>{{ row.item.fecha_fin }}</td>
                                            <td>{{ row.item.duracion_horas }}</td>
                                            <td>{{ row.item.nivel_estudio.descripcion }}</td>
                                            <td><v-chip small :color="row.item.estado_estudio.color">
                                                {{ row.item.estado_estudio.descripcion }}
                                            </v-chip>

                                            </td>
                                            <td>{{ (row.item.certificaciones!==null) ? row.item.certificaciones.solucion : 'NA'}}
                                            </td>
                                            <td>
                                                <v-btn small icon color="primary" :disabled="!row.item.documentos" @click="viewDocuments(row.item)">
                                                    <v-icon>mdi-download</v-icon>
                                                </v-btn>
                                            </td>
                                        </tr>
                                    </template>
                                </v-data-table>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="error"
                                    text
                                    @click="dialogEstudios = false"
                                >
                                    Cerrar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
        </template>
       <template>
            <v-row justify="center">
                <v-dialog v-model="dialogMeritos" persistent max-width="800px">
                    <v-card>
                        <v-card-title>
                            <span class="headline">Méritos y Deméritos</span>
                            <v-spacer></v-spacer>
                            <span >[{{persona_merito}}]</span>
                        </v-card-title>
                        <v-card-text>
                                <v-row dense>
                                    <v-col cols="12" sm="4">
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
                                            v-model="merito.fecha"
                                            label="Fecha"
                                            readonly
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                        </template>
                                        <v-date-picker
                                        v-model="merito.fecha"
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
                                    <v-col cols="12" sm="8">

                                                <v-select :items="autoridades"
                                            v-model="merito.autoridad_id"
                                                    label="Quién lo otorga"
                                                    hint="Seleccione la persona que otorga el mérito/demérito" >
                                            <template slot="selection" slot-scope="data">
                                                <!-- HTML that describe how select should render selected items -->
                                                {{ data.item.nombre }} {{ data.item.apellido }}
                                            </template>
                                            <template slot="item" slot-scope="data">
                                                <!-- HTML that describe how select should render items when the select is open -->
                                                {{ data.item.nombre }} {{ data.item.apellido }}
                                            </template>
                                        </v-select>
                                    </v-col>
                                    <v-col cols="12" sm="12">
                                        <v-textarea
                                            v-model="merito.descripcion"
                                            label="Descripción"
                                            required
                                            clearable
                                            rows="3"
                                        ></v-textarea>
                                    </v-col>


                                </v-row>

                                <v-row dense>
                                    <v-switch
                                            v-model="merito.is_merito"
                                            text
                                            color="orange darken-3"
                                            :label="`${merito.is_merito == true ? 'MÉRITO' : 'DEMÉRITO'}`"
                                        >
                                        </v-switch>
                                        <v-spacer></v-spacer>
                                        <v-btn color="error" text @click="dialogMeritos = false">
                                            Cerrar
                                        </v-btn>
                                        <v-btn
                                            color="primary"
                                            @click="createMerito"
                                        >
                                            Guardar
                                        </v-btn>
                                </v-row>
                                <v-row dense>
                                    <v-col cols="12">
                                        <v-simple-table  v-if="meritos.length>0" dark>
                            <template v-slot:default>
                            <thead>
                                <tr>
                                    <th class="text-left">
                                    Descripción
                                </th>
                                <th class="text-left">
                                    Fecha
                                </th>
                                <th class="text-left">
                                    Otorgó
                                </th>
                                <th class="text-left">
                                    Mérito / Demérito
                                </th>

                                <th class="text-left">
                                    Eliminar
                                </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                v-for="item in meritos"
                                :key="item.id"
                                >
                                <td>{{ item.descripcion }}</td>
                                <td>{{ item.fecha }}</td>
                                <td>{{ item.autoridad.nombre }}</td>
                                <td>{{ (item.is_merito==1) ? 'MÉRITO' : 'DEMÉRITO' }}</td>

                                <td>
                                    <v-btn small icon color="error" @click="deleteMerito(item)">
                                        <v-icon dark>mdi-delete</v-icon>
                                     </v-btn>
                                </td>
                                </tr>
                            </tbody>
                            </template>
                                    </v-simple-table>
                                    </v-col>

                                </v-row>
                        </v-card-text>
                    </v-card>
                </v-dialog>
            </v-row>
        </template>
    </div>
</template>

<script>
export default {
    data() {
        return {
            personas: [],
            persona_estudios: [],
            dialogEstudios: false,
            update: false,
            persona: {},
            loading: true,
            titleFormEstudios: null,
            search: "",
            searchEstudios: "",
            valid:true,
            headers: [
                { text: "Foto", value: "foto" },
                { text: "CI", value: "ci" },
                { text: "Nombre", value: "nombre" },
                { text: "Contacto", value: "email" },
                // { text: "Telefono", value: "telefono" },
                // { text: "Fecha nacimiento", value: "fecha_nacimiento" },
                { text: "Formación", value: "estudios" },
                { text: "Acciones", value: "controls", sortable: false }
            ],
            headersEstudios: [
                { text: "Descripcion/Titulo", value: "descripcion" },
                { text: "Institucion", value: "institucion" },
                { text: "Inicio", value: "fecha_inicio" },
                { text: "Fin", value: "fecha_fin" },
                { text: "Duracion (Horas)", value: "duracion_horas" },
                { text: "Tipo", value: "nivel_estudio" },
                { text: "Estado", value: "estado_estudio" },
                { text: "Certificacion", value: "certificacion", },
                { text: "Documentos", value: "controls", sortable: false }

            ],
            foto:null,
            dialogMeritos: false,
            merito:{},
            meritos:[],
            autoridades:[],
            date: new Date().toISOString().substr(0, 10),
            menu: false,
            fechaHoy: null,
            persona_merito:''


        };
    },
    created() {
        this.initialData();
    },
    methods: {
        estudios(el) {
                console.log(el);
                 this.loading = true;
                this.titleFormEstudios = `${el.nombre} ${el.apellido}`;
                this.foto = (!(el.foto==null || el.foto=='')) ? "data:image/png;base64," + el.foto : null;
                //this.usuario.id = el.id;
                this.axios.get(`/api/persona-estudios/${el.id}`).then(response => {
                    //this.personas = response.data;

                    this.persona_estudios=response.data;
                    console.log(this.persona_estudios);
                    this.dialogEstudios = true;
                    this.loading = false;
                });
            },
            viewDocuments(el){
                //console.log(el.documentos);
                var arrayDocumentos = el.documentos.split(',');
                console.log(arrayDocumentos);
                arrayDocumentos.forEach(element => {
                    window.open("data:image/png;base64,"+element,'_blank');
                });
                //this.logo = (!(el.logo==null || el.logo=='')) ? "data:image/png;base64," + el.logo : null;
            },
        deletePerson(el) {
            this.loading = true;
            this.axios.delete(`/api/persona/${el.id}`).then(response => {
                let i = this.personas.map(data => data.id).indexOf(el.id);
                this.personas.splice(i, 1);
                this.loading = false;
            });
        },
        deleteMerito(el) {
            this.loading = true;
            this.axios.delete(`/api/persona-merito/${el.id}`).then(() => {
                let i = this.meritos.map(data => data.id).indexOf(el.id);
                this.meritos.splice(i, 1);
                this.loading = false;
            });
        },
        openDialogMeritos(el){
            console.log(el);
            this.axios.get(`/api/persona-merito/${el.id}`).then(response => {
            this.meritos = response.data;
            console.log(this.meritos);
            this.autoridades=this.personas.filter(person => person.id!==el.id);
            //this.merito.is_merito=true;
            this.merito.descripcion=''
            this.merito.persona=el;
            this.persona_merito=el.nombre+' '+el.apellido;
            this.dialogMeritos = true;
        });


        },
        createMerito(){
            this.loading=true;
            this.merito.autoridad_id=this.merito.autoridad_id.id;
            this.merito.persona_id=this.merito.persona.id;
            this.merito.is_merito=(this.merito.is_merito) ? 1 : 0;
            console.log(this.merito);
               this.axios
                .post("/api/persona-merito", this.merito)
                .then(() => {
                    //this.refresh();
                    //this.initialData();
                    //this.dialogMeritos = false;
                    this.axios.get(`/api/persona-merito/${this.merito.persona_id}`).then(response => {
                        this.meritos = response.data;
                    })

                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));

        },
        downloadFile(archivo){
                console.log(archivo);
                let arrayArchivos = archivo.split(',');
                for (const file of arrayArchivos) {
                    this.axios
                        .get(`/api/get-file-persona/${file}`)
                        .then(response => {
                            const url=response.config.baseURL+response.config.url;
                            window.open(url,'_blank');
                        },error => {
                            console.log(error);
                            this.$toasted.error(`No se encontro el archivo: ${file}`)

                        });
                }

            },
            initialData(){
                this.axios.get("/api/persona").then(response => {
                    this.personas = response.data;

                    this.loading = false;
                });
                var f = new Date();
            this.fechaHoy = f.toISOString().substr(0, 10);
            this.merito.fecha=this.fechaHoy;

            }
    }
};
</script>
