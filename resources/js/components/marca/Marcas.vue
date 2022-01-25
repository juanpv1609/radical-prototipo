<template>

    <div>
        <v-card elevation="2" :loading="loading" outlined >
            <v-card-title
          >
           <v-badge
                :content="marcas.length"
                :value="marcas.length"
                color="green"

            >
            Marcas
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
              @click="addMarca"
          >
              <v-icon dark>
                  mdi-plus
              </v-icon>
          </v-btn>
        </v-card-title>

            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="marcas"
                    :search="search"

                >
                <template v-slot:item="row">
                    <tr>

                        <td>{{row.item.nombre}}</td>
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
                            <v-btn  icon color="primary" @click="editMarca(row.item)">
                                <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn  icon color="error" @click="deleteMarca(row.item)">
                                <v-icon dark>mdi-delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </template>
      </v-data-table>
            </v-card-text>
        </v-card>
        <template>
            <v-row justify="center">
                <v-dialog v-model="dialog" persistent max-width="600px">
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ titleForm }}</span>
                        </v-card-title>
                        <v-card-text>
                                <v-row dense>

                                    <v-col cols="12" >
                                        <v-text-field
                                            v-model="marca.nombre"
                                            label="Nombre de la marca o fabricante*"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea
                                        clearable
                                        rows="3"
                                        clear-icon="mdi-close-circle"
                                         v-model="marca.descripcion"
                                            label="Descripción de la marca o fabricante"
                                        ></v-textarea>
                                    </v-col>

                                </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-switch
                                class="pl-3"
                                v-model="marca.estado"
                                text
                                color="orange darken-3"
                                :label="
                                    `${
                                        marca.estado == true
                                            ? 'HABILITADO'
                                            : 'DESHABILITADO'
                                    }`
                                "
                            >
                            </v-switch>
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

                                @click="createMarca"
                            >
                                Guardar
                            </v-btn>
                            <v-btn
                                v-else
                                color="success"

                                @click="updateMarca"
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
            marca: {},
            marcas: [],
            loading: true,
            titleForm: null,
            search: "",
            headers: [
                { text: "Nombre", value: "nombre" },
                { text: "Descripcion", value: "descripcion" },
                { text: "Estado", value: "estado" },
                { text: "Acciones", sortable: false }
            ]
        };
    },
    created() {

        this.axios.get("/api/marcas/").then(response => {
            this.marcas = response.data;
            console.log(response.data);
            this.loading = false;

        });

    },
    methods: {
        createMarca() {
            this.marca.estado=(this.marca.estado) ? 1:0;
            console.log(this.marca);
            this.loading = true;
            this.axios
                .post("/api/marcas", this.marca)
                .then(() => {
                    this.dialog = false;
                    this.axios.get("/api/marcas/").then(response => {
                        this.marcas = response.data;
                        this.loading = false;

                    });
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        addMarca() {
            this.titleForm = "Nueva Marca / Fabricante";
            this.marca = {};
            this.update = false;
            this.dialog = true;
        },
        editMarca(el) {
            this.titleForm = "Editar Marca / Fabricante";
            this.update = true;
            this.marca.id = el.id;
            this.marca.nombre = el.nombre;
            this.marca.descripcion = el.descripcion;
            this.marca.estado = (el.estado==1 ? true:false);
            this.dialog = true;
        },
        updateMarca() {
            this.loading = true;
            this.axios
                .patch(`/api/marcas/${this.marca.id}`, this.marca)
                .then(res => {
                    this.dialog = false;
                    this.axios.get("/api/marcas/").then(response => {
                        this.marcas = response.data;
                        this.loading = false;
                    });
                });
        },
        deleteMarca(el) {
            this.loading = true;
            this.axios.delete(`/api/marcas/${el.id}`).then(() => {
                let i = this.marcas.map(data => data.id).indexOf(el.id);
                this.marcas.splice(i, 1);
                this.loading = false;
            });
        }
    }
};
</script>
