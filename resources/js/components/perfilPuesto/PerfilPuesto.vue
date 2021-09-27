<template>
    <div>
            <v-card elevation="2" :loading="loading">
                <v-card-title
          >
           <v-badge
                :content="perfiles.length"
                :value="perfiles.length"
                color="green"

            >
            Perfiles Laborales
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
              @click="addPerfil"
          >
              <v-icon dark>
                  mdi-plus
              </v-icon>
          </v-btn>
        </v-card-title>

                <v-card-text>
                    <v-data-table
                        :headers="headers"
                        :items="perfiles"
                        :search="search"
                    >
                    <template v-slot:item="row">
                        <tr>
                            <td>{{row.item.area.nombre}}</td>
                            <td>{{row.item.descripcion}}</td>
                            <td> <v-chip
                                            v-for="funcion in row.item.funciones"
                                            :key="funcion"
                                            small
                                            label
                                            class="ma-1"
                                        >
                                            {{ funcion }}
                                        </v-chip>
                                        </td>

                            <td> <v-chip
                                            v-for="responsabilidad in row.item.responsabilidades"
                                            :key="responsabilidad"
                                            small
                                            label
                                            class="ma-1"
                                        >
                                            {{ responsabilidad }}
                                        </v-chip></td>
                            <td>
                                <v-btn  icon color="primary" @click="editPerfil(row.item)">
                                    <v-icon dark>mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn   icon color="error" @click="deletePerfil(row.item)">
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
                    <v-dialog v-model="dialog" persistent max-width="800px">
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ titleForm }}</span>
                            </v-card-title>
                            <v-card-text>
                                    <v-row>
                                        <v-col cols="12" sm="6">

                                                <v-autocomplete
                                                    :items="areas"
                                                    item-text="nombre"
                                                    item-value="id"
                                                    v-model="perfil.area"
                                                    label="Seleccione un area"
                                                    return-object
                                                ></v-autocomplete>
                                        </v-col>
                                        <v-col cols="12" sm="6">

                                            <v-text-field
                                                v-model="perfil.descripcion"
                                                label="Nombre / Descripción del perfil laboral*"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-combobox
                                                    v-model="modelFunciones"
                                                    :items="itemsFunciones"
                                                    hide-selected
                                                    hint="Ingrese la función y presione Enter o TAB "
                                                    label="Funciones"
                                                    multiple
                                                    persistent-hint
                                                    small-chips
                                                    deletable-chips
                                                >
                                                </v-combobox>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-combobox
                                                    v-model="modelResponsabilidades"
                                                    :items="itemsResponsabilidades"
                                                    hide-selected
                                                    hint="Ingrese la responsabilidad y presione Enter o TAB "
                                                    label="Responsabilidades"
                                                    multiple
                                                    persistent-hint
                                                    small-chips
                                                    deletable-chips
                                                >
                                                </v-combobox>
                                        </v-col>
                                    </v-row>

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

                                    @click="createPeril"
                                >
                                    Guardar
                                </v-btn>
                                <v-btn
                                    v-else
                                    color="primary"

                                    @click="updatePerfil"
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
import moment from 'moment';
    export default {
        data() {
            return {
                perfiles: [],
                area: {},
                areas: [],
                dialog: false,
                update: false,
                perfil: {},
                loading: true,
                titleForm: null,
                search: "",

                headers: [

                { text: "Area", value: "area" },
                { text: "Descripción", value: "descripcion" },
                { text: "Funciones", value: "funciones" },
                { text: "Responsabilidades", value: "responsabilidades" },
                { text: "Acciones", value: "controls", sortable: false }
            ],
            modelFunciones:[],
            modelResponsabilidades:[],
            itemsFunciones:[],
            itemsResponsabilidades:[],

            }
        },
        created() {
            this.getData();
        },
        methods: {
            getData(){
                this.loading=true;
                this.axios
                .get('/api/perfil-puesto')
                .then(response => {
                    this.perfiles = response.data;
                    this.perfiles.forEach(element => {

                        element.funciones=element.funciones.split(',');
                        element.responsabilidades=element.responsabilidades.split(',');
                    });
                    this.loading = false;
                });

            },
            addPerfil() {

                this.titleForm = "Nuevo Perfil Laboral";
                this.perfil = {};
                this.modelFunciones=[];
                this.modelResponsabilidades=[];
                this.axios.get("/api/areas/").then(response => {
                    this.areas = response.data;
                //this.loading = false;

                });
                this.update = false;
                this.dialog = true;
            },
            editPerfil(el) {
                console.log(el);
                this.axios.get("/api/areas/").then(response => {
                    this.areas = response.data;
                    this.titleForm = "Editar Perfil Laboral";
                    this.update = true;
                    this.perfil.id = el.id;
                    this.perfil.descripcion = el.descripcion;
                    this.perfil.area_id=el.area_id;
                    this.perfil.area=el.area;
                    this.modelFunciones=el.funciones;
                    this.modelResponsabilidades=el.responsabilidades;

                    this.dialog = true;

                });

            },
            createPeril() {
                this.loading = true;
                this.perfil.area_id=this.perfil.area.id;
                this.perfil.funciones=this.modelFunciones;
                this.perfil.responsabilidades=this.modelResponsabilidades;
                console.log(this.perfil);
                 this.axios
                    .post('/api/perfil-puesto', this.perfil)
                    .then(() => {
                        this.dialog = false;
                        this.loading = false;
                        this.getData();
                         })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },
            updatePerfil() {
                this.loading = true;
                this.perfil.area_id=this.perfil.area.id;
                this.perfil.funciones=this.modelFunciones;
                this.perfil.responsabilidades=this.modelResponsabilidades;
                this.axios
                    .patch(`/api/perfil-puesto/${this.perfil.id}`, this.perfil)
                    .then(() => {
                        this.dialog = false;
                        this.loading = false;
                        this.getData();
                    });
            },
            deletePerfil(el) {
                this.loading = true;
                this.axios
                    .delete(`/api/perfil-puesto/${el.id}`)
                    .then(() => {
                        let i = this.perfiles.map(data => data.id).indexOf(el.id);
                        this.perfiles.splice(i, 1);
                        this.loading = false;
                    });
            }
        }
    }
</script>
