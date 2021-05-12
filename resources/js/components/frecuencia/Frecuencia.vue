<template>

    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title
          >
           <v-badge
                :content="frecuencias.length"
                :value="frecuencias.length"
                color="green"

            >
            Frecuencias
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
              @click="addFrecuencia"
          >
              <v-icon dark>
                  mdi-plus
              </v-icon>
          </v-btn>
        </v-card-title>

            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="frecuencias"
                    :search="search"
                >
                <template v-slot:item="row">
                    <tr>
                        <td>{{row.item.id}}</td>
                        <td>{{row.item.descripcion}}</td>
                        <td>{{row.item.alerta}} dias</td>
                        <td>
                            <v-chip v-if="row.item.estado==1"
                            class="ma-2"
                            color="success"
                            small
                            >Habilitada
                            </v-chip>
                            <v-chip v-else
                            class="ma-2"
                            color="error"
                            small
                            >Deshabilitada
                            </v-chip>
                        </td>
                        <td>
                            <v-btn  icon color="primary" @click="editFrecuencia(row.item)">
                                <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn  icon color="error" @click="deleteFrecuencia(row.item)">
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
                                            v-model="frecuencia.descripcion"
                                            label="Descripcion"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="frecuencia.alerta"
                                            label="Alerta*"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-select :items="estado"
                                            v-model="frecuencia.estado"
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
                                @click="createFrecuencia"
                            >
                                Guardar
                            </v-btn>
                            <v-btn
                                v-else
                                color="primary"
                                text
                                @click="updateFrecuencia"
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
            frecuencia: {},
            frecuencias: [],
            loading: true,
            titleForm: null,
            search: "",
            estado: [
                { text: "HABILITADA", value: 1 },
                { text: "DESHABILITADA", value: 0 },
            ],
            headers: [
                {
                    text: "Id",
                    // align: 'start',
                    // filterable: false,
                    value: "id"
                },
                { text: "Descripcion", value: "descripcion" },
                { text: "Alerta", value: "alerta" },
                { text: "Estado", value: "estado" },
                { text: "Acciones", sortable: false }
            ]
        };
    },
    created() {

        this.axios.get("/api/frecuencias-all/").then(response => {
            this.frecuencias = response.data;
            this.loading = false;

        });
    },
    methods: {
        createFrecuencia() {
            this.loading = true;
            this.axios
                .post("/api/frecuencias", this.frecuencia)
                .then(() => {
                    this.dialog = false;
                    this.axios.get("/api/frecuencias-all/").then(response => {
                        this.frecuencias = response.data;
                        this.loading = false;

                    });
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        addFrecuencia() {
            this.titleForm = "Nueva Frecuencia";
            this.frecuencia = {};
            this.update = false;
            this.dialog = true;
        },
        editFrecuencia(el) {
            this.titleForm = "Editar Frecuencia";
            this.update = true;
            this.frecuencia.id = el.id;
            this.frecuencia.descripcion = el.descripcion;
            this.frecuencia.alerta = el.alerta;
            this.frecuencia.estado = el.estado;
            this.dialog = true;
        },
        updateFrecuencia() {
            this.loading = true;
            this.axios
                .patch(`/api/frecuencias/${this.frecuencia.id}`, this.frecuencia)
                .then(res => {
                    this.dialog = false;
                    this.axios.get("/api/frecuencias-all/").then(response => {
                        this.frecuencias = response.data;
                        this.loading = false;
                    });
                });
        },
        deleteFrecuencia(el) {
            this.loading = true;
            this.axios.delete(`/api/frecuencias/${el.id}`).then(() => {
                let i = this.frecuencias.map(data => data.id).indexOf(el.id);
                this.frecuencias.splice(i, 1);
                this.loading = false;
            });
        }
    }
};
</script>
