<template>

    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6"
                >Paises
                <v-btn
                    class="mx-2"
                    fab
                    dark
                    small
                    color="primary"
                    @click="addPais"
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
                    :items="paises"
                    :search="search"
                >
                <template v-slot:item="row">
                    <tr>
                        <td>{{row.item.id}}</td>
                        <td>{{row.item.nombre}}</td>
                        <td>{{row.item.abreviatura}}</td>
                        <td>
                            <v-chip v-if="row.item.estado==1"
                            class="ma-2"
                            color="success"
                            small
                            >Habilitado
                            </v-chip>
                            <v-chip v-else
                            class="ma-2"
                            color="error"
                            small
                            >Deshabilitado
                            </v-chip>
                        </td>
                        <td>
                            <v-btn  icon color="primary" @click="editPais(row.item)">
                                <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn  icon color="error" @click="deletePais(row.item)">
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
                <v-dialog v-model="dialog" persistent max-width="400px">
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ titleForm }}</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>

                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="pais.nombre"
                                            label="Nombre"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="pais.abreviatura"
                                            label="Abreviatura*"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-select :items="estado"
                                            v-model="pais.estado"
                                                label="Estado" >
                                            <template slot="selection" slot-scope="data">
                                                <!-- HTML that describe how select should render selected items -->
                                                {{ data.item.text }}
                                            </template>
                                            <template slot="item" slot-scope="data">
                                                <!-- HTML that describe how select should render items when the select is open -->
                                                {{ data.item.text }}
                                            </template>
                                        </v-select>
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
                                @click="createPais"
                            >
                                Guardar
                            </v-btn>
                            <v-btn
                                v-else
                                color="primary"
                                text
                                @click="updatePais"
                            >
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

export default {
    data() {
        return {
            showScheduleForm: false,
            dialog: false,
            update: false,
            pais: {},
            paises: [],
            loading: true,
            titleForm: null,
            search: "",
            estado: [
                { text: "HABILITADO", value: 1 },
                { text: "DESHABILITADO", value: 0 },
            ],
            headers: [
                {
                    text: "Id",
                    // align: 'start',
                    // filterable: false,
                    value: "id"
                },
                { text: "Nombre", value: "nombre" },
                { text: "Abreviatua", value: "abreviatura" },
                { text: "Estado", value: "estado" },
                { text: "Acciones", sortable: false }
            ]
        };
    },
    created() {

        this.axios.get("/api/paises/").then(response => {
            this.paises = response.data;
            this.loading = false;

        });
    },
    methods: {
        createPais() {
            this.loading = true;
            this.axios
                .post("/api/paises", this.pais)
                .then(() => {
                    this.dialog = false;
                    this.axios.get("/api/paises/").then(response => {
                        this.paises = response.data;
                        this.loading = false;

                    });
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        addPais() {
            this.titleForm = "Nuevo Pais";
            this.pais = {};
            this.update = false;
            this.dialog = true;
        },
        editPais(el) {
            this.titleForm = "Editar Pais";
            this.update = true;
            this.pais.id = el.id;
            this.pais.nombre = el.nombre;
            this.pais.abreviatura = el.abreviatura;
            this.pais.estado = el.estado;
            this.dialog = true;
        },
        updatePais() {
            this.loading = true;
            this.axios
                .patch(`/api/paises/${this.pais.id}`, this.pais)
                .then(res => {
                    this.dialog = false;
                    this.axios.get("/api/paises/").then(response => {
                        this.paises = response.data;
                        this.loading = false;
                    });
                });
        },
        deletePais(el) {
            this.loading = true;
            this.axios.delete(`/api/paises/${el.id}`).then(() => {
                let i = this.paises.map(data => data.id).indexOf(el.id);
                this.paises.splice(i, 1);
                this.loading = false;
            });
        }
    }
};
</script>
