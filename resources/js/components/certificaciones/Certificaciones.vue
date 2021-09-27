<template>
    <div>
            <v-card elevation="2" :loading="loading">
                <v-card-title >
                    <v-badge
                :content="certificaciones.length"
                :value="certificaciones.length"
                color="green"

            >
            Certificaciones
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
                        :items="certificaciones"
                        :search="search"
                    >
                    <template v-slot:item="row">
                        <tr>
                            <td>{{row.item.id}}</td>
                            <td>{{row.item.solucion}}</td>
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
                                    <v-btn :disabled="row.item.role==2"  icon color="error" @click="deleteCertificacion(row.item)">
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
                    <v-dialog v-model="dialog" persistent max-width="600px">
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ titleForm }}</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row dense>
                                        <v-col cols="12">
                                            <v-textarea
                                            clearable
                                                v-model="certificacion.solucion"
                                                label="Nombre de la solución o herramienta*"
                                                required
                                                rows="3"
                                            ></v-textarea>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-switch
                                            v-model="certificacion.estado"
                                            :label="`${(certificacion.estado==true) ? 'HABILITADO' : 'DESHABILITADO'}`"
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

                                    @click="createCertificate"
                                >
                                    Guardar
                                </v-btn>
                                <v-btn
                                    v-else
                                    color="primary"

                                    @click="updateCertificate"
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
                certificaciones: [],
                dialog: false,
                update: false,
                certificacion: {},
                loading: true,
                titleForm: null,
                search: "",

                headers: [
                { text: "ID", value: "id" },
                { text: "Solucion / Herramienta", value: "solucion" },
                { text: "Estado", value: "estado" },
                { text: "Acciones", value: "controls", sortable: false }
            ]

            }
        },
        created() {
            this.axios
                .get('/api/certificaciones')
                .then(response => {
                    this.certificaciones = response.data;
                    this.loading = false;
                });
        },
        methods: {
            add() {

                this.titleForm = "Nueva Certificacion";
                this.certificacion = {};
                this.update = false;
                this.dialog = true;
            },
            edit(el) {
                console.log(el);
                this.titleForm = "Editar Certificacion";
                this.update = true;
                this.certificacion.id = el.id;
                this.certificacion.solucion = el.solucion;
                this.certificacion.estado = el.estado;
                this.dialog = true;
            },
            createCertificate() {
                this.certificacion.estado = (this.certificacion.estado) ? 1 : 0;
                console.log(this.certificacion);
                 this.loading = true;
                this.axios
                    .post('/api/certificaciones', this.certificacion)
                    .then(response => {
                        this.dialog = false;
                        this.loading = false;
                        this.axios
                            .get('/api/certificaciones')
                            .then(response => {
                                this.certificaciones = response.data;

                            });
                         })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },
            updateCertificate() {
                this.certificacion.estado = (this.certificacion.estado) ? 1 : 0;
                this.loading = true;
                this.axios
                    .patch(`/api/certificaciones/${this.certificacion.id}`, this.certificacion)
                    .then((res) => {
                        this.dialog = false;
                        this.loading = false;
                        this.axios
                            .get('/api/certificaciones')
                            .then(response => {
                                this.certificaciones = response.data;
                            });
                    });
            },
            deleteCertificacion(el) {
                this.loading = true;
                this.axios
                    .delete(`/api/certificaciones/${el.id}`)
                    .then(response => {
                        let i = this.certificaciones.map(data => data.id).indexOf(el.id);
                        this.certificaciones.splice(i, 1);
                        this.loading = false;
                    });
            }
        }
    }
</script>
