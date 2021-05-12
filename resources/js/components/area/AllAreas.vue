<template>

    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title
          >
          <v-badge
                :content="areas.length"
                :value="areas.length"
                color="green"

            >
            Areas
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
              @click="addArea"
          >
              <v-icon dark>
                  mdi-plus
              </v-icon>
          </v-btn>
        </v-card-title>

            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="areas"
                    :search="search"
                >
                <template v-slot:item="row">
                    <tr>
                        <td>{{row.item.id}}</td>
                        <td>{{row.item.nombre}}</td>
                        <td>{{row.item.descripcion}}</td>
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
                            <v-btn  icon color="primary" @click="editArea(row.item)">
                                <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn  icon color="error" @click="deleteArea(row.item)">
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
                                <v-form @submit.prevent="createArea"> </v-form>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="area.nombre"
                                            label="Nombre del area*"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="area.descripcion"
                                            label="Descripcion"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-select :items="estado"
                                            v-model="area.estado"
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
                                @click="createArea"
                            >
                                Guardar
                            </v-btn>
                            <v-btn
                                v-else
                                color="primary"
                                text
                                @click="updateArea"
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
            area: {},
            areas: [],
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
                { text: "Nombre", value: "nombre" },
                { text: "Descripcion", value: "descripcion" },
                { text: "Estado", value: "estado" },
                { text: "Acciones", sortable: false }
            ]
        };
    },
    created() {

        this.axios.get("/api/areas/").then(response => {
            this.areas = response.data;
            this.loading = false;

        });
    },
    methods: {
        createArea() {
            this.loading = true;
            this.axios
                .post("/api/areas", this.area)
                .then(() => {
                    this.dialog = false;
                    this.axios.get("/api/areas/").then(response => {
                        this.areas = response.data;
                        this.loading = false;

                    });
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        addArea() {
            this.titleForm = "Nueva Area";
            this.area = {};
            this.update = false;
            this.dialog = true;
        },
        editArea(el) {
            this.titleForm = "Editar Area";
            this.update = true;
            this.area.id = el.id;
            this.area.nombre = el.nombre;
            this.area.descripcion = el.descripcion;
            this.area.estado = el.estado;
            this.dialog = true;
        },
        updateArea() {
            this.loading = true;
            this.axios
                .patch(`/api/areas/${this.area.id}`, this.area)
                .then(res => {
                    this.dialog = false;
                    this.axios.get("/api/areas/").then(response => {
                        this.areas = response.data;
                        this.loading = false;
                    });
                });
        },
        deleteArea(el) {
            this.loading = true;
            this.axios.delete(`/api/areas/${el.id}`).then(() => {
                let i = this.areas.map(data => data.id).indexOf(el.id);
                this.areas.splice(i, 1);
                this.loading = false;
            });
        }
    }
};
</script>
