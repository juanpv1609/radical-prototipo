<template>
    <div>
            <v-card elevation="2" :loading="loading">
                <v-card-title
                    >
                    <v-badge
                :content="nivelEstudios.length"
                :value="nivelEstudios.length"
                color="green"

            >
            Niveles de estudio
            </v-badge>
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
                        @click="add"
                    >
                        <v-icon dark>
                            mdi-plus
                        </v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-text>
                    <v-data-table
                        :headers="headers"
                        :items="nivelEstudios"
                        :search="search"
                    >
                    <template v-slot:item="row">
                        <tr>
                            <td>{{row.item.id}}</td>
                            <td>{{row.item.descripcion}}</td>
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
                                <v-btn  icon color="primary" @click="edit(row.item)">
                                    <v-icon dark>mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn :disabled="row.item.role==2"  icon color="error" @click="deleteNivel(row.item)">
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
                                    <v-row dense>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="nivelEstudio.descripcion"
                                                label="Descripción del nivel de estudio*"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-switch
                                            v-model="nivelEstudio.estado"
                                            :label="`${(nivelEstudio.estado==true) ? 'HABILITADO' : 'DESHABILITADO'}`"
                                            ></v-switch>
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

                                    @click="createNivelEstudio"
                                >
                                    Guardar
                                </v-btn>
                                <v-btn
                                    v-else
                                    color="primary"

                                    @click="updateNivelEstudio"
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
                nivelEstudios: [],
                dialog: false,
                update: false,
                nivelEstudio: {},
                loading: true,
                titleForm: null,
                search: "",

                headers: [
                { text: "ID", value: "id" },
                { text: "Descripción", value: "descripcion" },
                { text: "Estado", value: "estado" },
                { text: "Acciones", value: "controls", sortable: false }
            ]

            }
        },
        created() {
            this.axios
                .get('/api/nivel-estudio')
                .then(response => {
                    this.nivelEstudios = response.data;
                    this.loading = false;
                });
        },
        methods: {
            add() {

                this.titleForm = "Nuevo Nivel de Estudio";
                this.nivelEstudio = {};
                this.update = false;
                this.dialog = true;
            },
            edit(el) {
                console.log(el);
                this.titleForm = "Editar Nivel de Estudio";
                this.update = true;
                this.nivelEstudio.id = el.id;
                this.nivelEstudio.descripcion = el.descripcion;
                this.nivelEstudio.estado = el.estado;
                this.dialog = true;
            },
            createNivelEstudio() {
                this.nivelEstudio.estado = (this.nivelEstudio.estado) ? 1 : 0;
                console.log(this.nivelEstudio);
                 this.loading = true;
                this.axios
                    .post('/api/nivel-estudio', this.nivelEstudio)
                    .then(response => {
                        this.dialog = false;
                        this.loading = false;
                        this.axios
                            .get('/api/nivel-estudio')
                            .then(response => {
                                this.nivelEstudios = response.data;

                            });
                         })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },
            updateNivelEstudio() {
                this.nivelEstudio.estado = (this.nivelEstudio.estado) ? 1 : 0;
                this.loading = true;
                this.axios
                    .patch(`/api/nivel-estudio/${this.nivelEstudio.id}`, this.nivelEstudio)
                    .then((res) => {
                        this.dialog = false;
                        this.loading = false;
                        this.axios
                            .get('/api/nivel-estudio')
                            .then(response => {
                                this.nivelEstudios = response.data;
                            });
                    });
            },
            deleteNivel(el) {
                this.loading = true;
                this.axios
                    .delete(`/api/nivel-estudio/${el.id}`)
                    .then(response => {
                        let i = this.nivelEstudios.map(data => data.id).indexOf(el.id);
                        this.nivelEstudios.splice(i, 1);
                        this.loading = false;
                    });
            }
        }
    }
</script>
