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
                                <v-avatar v-if="row.item.foto">
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

                            <td>{{ row.item.email }}</td>
                            <td>{{ row.item.telefono }}</td>
                            <td>{{ row.item.fecha_nacimiento }}</td>
                            <td>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn  icon v-bind="attrs"
                                            v-on="on" color="primary" @click="downloadFile(row.item.documentos)" target="_blank"
                                            :disabled="row.item.documentos==null || row.item.documentos==''">
                                            <v-icon dark>mdi-download</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{ row.item.documentos }}</span>
                                    </v-tooltip>
                            </td>
                            <td>
                                <v-btn
                                    icon
                                    color="primary"
                                >
                                    <v-icon dark @click="estudios(row.item)">mdi-school</v-icon>
                                </v-btn>
                            </td>
                            <td>
                                <v-btn
                                    icon
                                    color="black"
                                    :to="{
                                                name: 'personal-edit',
                                                params: { id: row.item.id }
                                            }"
                                >
                                    <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn
                                    :disabled="row.item.role == 2"
                                    icon
                                    color="error"
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
                { text: "Email", value: "email" },
                { text: "Telefono", value: "telefono" },
                { text: "Fecha nacimiento", value: "fecha_nacimiento" },
                { text: "Documentos", value: "documentos" },
                { text: "Estudios", value: "estudios" },
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
            foto:null
        };
    },
    created() {
        this.axios.get("/api/persona").then(response => {
            this.personas = response.data;

            this.loading = false;
        });
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
    }
};
</script>
