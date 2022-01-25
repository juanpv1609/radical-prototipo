<template>

    <div>
        <v-card elevation="2" :loading="loading" outlined >
            <v-card-title
          >
           <v-badge
                :content="servicios.length"
                :value="servicios.length"
                color="green"

            >
            Servicios
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
              @click="addServicio"
          >
              <v-icon dark>
                  mdi-plus
              </v-icon>
          </v-btn>
        </v-card-title>

            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="servicios"
                    :search="search"

                >
                <template v-slot:item="row">
                    <tr>

                        <td>{{row.item.nombre}}</td>
                        <td>{{row.item.descripcion}}</td>
                        <td>{{row.item.area.nombre}}</td>
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
                            <v-btn  icon color="primary" @click="editServicio(row.item)">
                                <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn  icon color="error" @click="deleteServicio(row.item)">
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
                <v-dialog v-model="dialog" persistent max-width="700px">
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ titleForm }}</span>
                        </v-card-title>
                        <v-card-text>
                                <v-row dense>
                                    <v-col cols="12" sm="4">

                                    <v-autocomplete
                                    :items="areas"
                                    item-text="nombre"
                                    item-value="id"
                                    v-model="servicio.area"
                                    label="Seleccione un area"
                                    return-object

                                ></v-autocomplete>
                                    </v-col>
                                    <v-col cols="12" sm="8">
                                        <v-text-field
                                            v-model="servicio.nombre"
                                            label="Nombre del servicio*"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea
                                        clearable
                                        rows="3"
                                        clear-icon="mdi-close-circle"
                                         v-model="servicio.descripcion"
                                            label="Descripción del servicio"
                                        ></v-textarea>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea
                                        clearable
                                        rows="3"
                                        clear-icon="mdi-close-circle"
                                         v-model="servicio.observaciones"
                                            label="Observaciones"
                                        ></v-textarea>
                                    </v-col>

                                </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-switch
                                class="pl-3"
                                v-model="servicio.estado"
                                text
                                color="orange darken-3"
                                :label="
                                    `${
                                        servicio.estado == true
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

                                @click="createServicio"
                            >
                                Guardar
                            </v-btn>
                            <v-btn
                                v-else
                                color="success"

                                @click="updateTipoTarea"
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
            servicio: {},
            servicios: [],
            loading: true,
            titleForm: null,
            search: "",
            areas: {},
            headers: [
                { text: "Nombre", value: "nombre" },
                { text: "Descripcion", value: "descripcion" },
                { text: "Area", value: "area" },
                { text: "Estado", value: "estado" },
                { text: "Acciones", sortable: false }
            ]
        };
    },
    created() {

        this.axios.get("/api/servicios/").then(response => {
            this.servicios = response.data;
            console.log(response.data);
            this.loading = false;

        });
        this.axios.get("/api/areas/").then(response => {
            this.areas = response.data;
            //console.log(response.data);
        });
    },
    methods: {
        createServicio() {
            this.servicio.area_id=this.servicio.area.id;
            this.servicio.estado=(this.servicio.estado) ? 1:0;
            console.log(this.servicio);
            this.loading = true;
            this.axios
                .post("/api/servicios", this.servicio)
                .then(() => {
                    this.dialog = false;
                    this.axios.get("/api/servicios/").then(response => {
                        this.servicios = response.data;
                        this.loading = false;

                    });
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        addServicio() {
            this.titleForm = "Nuevo Servicio";
            this.servicio = {};
            this.update = false;
            this.dialog = true;
        },
        editServicio(el) {
            this.titleForm = "Editar Servicio";
            this.update = true;
            this.servicio.id = el.id;
            this.servicio.area = el.area;
            this.servicio.nombre = el.nombre;
            this.servicio.descripcion = el.descripcion;
            this.servicio.estado = (el.estado==1 ? true:false);
            this.dialog = true;
        },
        updateTipoTarea() {
            this.loading = true;
            this.axios
                .patch(`/api/servicios/${this.servicio.id}`, this.servicio)
                .then(res => {
                    this.dialog = false;
                    this.axios.get("/api/servicios/").then(response => {
                        this.servicios = response.data;
                        this.loading = false;
                    });
                });
        },
        deleteServicio(el) {
            this.loading = true;
            this.axios.delete(`/api/servicios/${el.id}`).then(() => {
                let i = this.servicios.map(data => data.id).indexOf(el.id);
                this.servicios.splice(i, 1);
                this.loading = false;
            });
        }
    }
};
</script>
