<template>

    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6"
                >Tipos de Tareas
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
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
                <v-data-table
                    :headers="headers"
                    :items="tipo_tareas"
                    :search="search"
                >
                <template v-slot:item="row">
                    <tr>
                        <td>{{row.item.id}}</td>
                        <td>{{row.item.nombre}}</td>
                        <td>{{row.item.descripcion}}</td>
                        <td>
                            <v-btn  icon color="primary" @click="editTipoTarea(row.item)">
                                <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn  icon color="error" @click="deleteTipoTarea(row.item)">
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
                                            v-model="tipo_tarea.nombre"
                                            label="Nombre del tipo de tarea*"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-textarea
                                        clearable
                                        rows="2"
                                        clear-icon="mdi-close-circle"
                                         v-model="tipo_tarea.descripcion"
                                            label="Descripcion"
                                        ></v-textarea>
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
                                @click="createTipoTarea"
                            >
                                Guardar
                            </v-btn>
                            <v-btn
                                v-else
                                color="primary"
                                text
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
            tipo_tarea: {},
            tipo_tareas: [],
            loading: true,
            titleForm: null,
            search: "",
            headers: [
                {
                    text: "Id",
                    // align: 'start',
                    // filterable: false,
                    value: "id"
                },
                { text: "Nombre", value: "nombre" },
                { text: "Descripcion", value: "descripcion" },
                { text: "Acciones", sortable: false }
            ]
        };
    },
    created() {

        this.axios.get("/api/tareas-tipo/").then(response => {
            this.tipo_tareas = response.data;
            console.log(response.data);
            this.loading = false;

        });
    },
    methods: {
        createTipoTarea() {
            this.loading = true;
            this.axios
                .post("/api/tareas-tipo", this.tipo_tarea)
                .then(() => {
                    this.dialog = false;
                    this.axios.get("/api/tareas-tipo/").then(response => {
                        this.tipo_tareas = response.data;
                        this.loading = false;

                    });
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        addArea() {
            this.titleForm = "Nueva Tipo Tarea";
            this.tipo_tarea = {};
            this.update = false;
            this.dialog = true;
        },
        editTipoTarea(el) {
            this.titleForm = "Editar Tipo Tarea";
            this.update = true;
            this.tipo_tarea.id = el.id;
            this.tipo_tarea.nombre = el.nombre;
            this.tipo_tarea.descripcion = el.descripcion;
            this.dialog = true;
        },
        updateTipoTarea() {
            this.loading = true;
            this.axios
                .patch(`/api/tareas-tipo/${this.tipo_tarea.id}`, this.tipo_tarea)
                .then(res => {
                    this.dialog = false;
                    this.axios.get("/api/tareas-tipo/").then(response => {
                        this.tipo_tareas = response.data;
                        this.loading = false;
                    });
                });
        },
        deleteTipoTarea(el) {
            this.loading = true;
            this.axios.delete(`/api/tareas-tipo/${el.id}`).then(() => {
                let i = this.tipo_tareas.map(data => data.id).indexOf(el.id);
                this.tipo_tareas.splice(i, 1);
                this.loading = false;
            });
        }
    }
};
</script>
