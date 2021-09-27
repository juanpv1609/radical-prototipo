<template>
    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title>
                <v-badge
                    :content="casosDeUso.length"
                    :value="casosDeUso.length"
                    color="green"
                >
                    Casos de Uso
                </v-badge>
                <v-spacer></v-spacer>
                <v-chip small color="primary"> IT={{ cuentaIT }} </v-chip>
                <v-chip small color="success"> OT={{ cuentaOT }} </v-chip>
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
                    @click="addCasoDeUso"
                >
                    <v-icon dark>
                        mdi-plus
                    </v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text>
                <v-data-table
                    :headers="headers"
                    :items="casosDeUso"
                    :search="search"
                    item-key="id"
                        v-model="selected"
                        show-select
                >
                    <template v-slot:item="row">
                        <tr>
                            <td><v-checkbox
                                :input-value="row.isSelected"
                                @change="row.select($event)"
                                hide-details

                                ></v-checkbox>
                                </td>
                            <td>{{ row.item.nombre }}</td>
                            <td>{{ row.item.descripcion }}</td>
                            <!-- <td>{{ row.item.resultado_esperado }}</td> -->
                            <td>{{ row.item.tipo }}</td>
                            <td>
                                <div v-if="row.item.fuentes">
                                    <v-chip
                                        v-for="fuente in row.item.fuentes.split(
                                            ','
                                        )"
                                        :key="fuente"
                                        class="ma-1"
                                        small
                                        color="primary"
                                    >
                                        {{ fuente }}
                                    </v-chip>
                                </div>
                            </td>
                            <!-- <td>{{ row.item.escenario }}</td> -->
                            <td>
                                <v-tooltip bottom v-if="row.item.estado == 1">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon
                                            v-bind="attrs"
                                            v-on="on"
                                            color="success"
                                        >
                                            mdi-arrow-up-bold-box
                                        </v-icon>
                                    </template>
                                    <span>Activo</span>
                                </v-tooltip>
                                <v-tooltip bottom v-else>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-icon
                                            v-bind="attrs"
                                            v-on="on"
                                            color="error"
                                        >
                                            mdi-arrow-down-bold-box
                                        </v-icon>
                                    </template>
                                    <span>Inactivo</span>
                                </v-tooltip>
                            </td>
                            <td>
                                <v-btn
                                    icon
                                    color="dark"
                                    small
                                    @click="editCasoDeUso(row.item)"
                                >
                                    <v-icon dark>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn
                                    icon
                                    color="error"
                                    small
                                    @click="deleteCasoDeUso(row.item)"
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
                <v-dialog v-model="dialog" persistent max-width="600px">
                    <v-card>
                        <v-card-title>
                            <span class="headline">{{ titleForm }}</span>
                        </v-card-title>
                        <v-card-text>
                                <v-row dense>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="casoDeUso.nombre"
                                            label="Nombre del caso de uso"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="12">
                                        <v-textarea
                                            v-model="casoDeUso.descripcion"
                                            label="Descripcion"
                                            required
                                            clearable
                                            rows="3"
                                        ></v-textarea>
                                    </v-col>

                                    <v-col cols="12" sm="8">
                                        <v-combobox
                                            v-model="casoDeUso.fuentes"
                                            :items="itemsFuentes"
                                            hide-selected
                                            hint="Ingrese el nombre de fuente (logSource) y presione TAB o ENTER "
                                            label="Fuentes de Eventos (logSources)"
                                            multiple
                                            persistent-hint
                                            chips
                                            deletable-chips
                                        >
                                        </v-combobox>
                                    </v-col>
                                    <v-col cols="12" sm="4">
                                        <v-radio-group
                                            v-model="casoDeUso.tipo"
                                            row
                                            dense
                                        >
                                            <v-radio value="IT" color="success">
                                                <template v-slot:label>
                                                    <strong
                                                        class="success--text"
                                                        >IT</strong
                                                    >
                                                </template>
                                            </v-radio>
                                            <v-radio value="OT" color="primary">
                                                <template v-slot:label>
                                                    <strong
                                                        class="primary--text"
                                                        >OT</strong
                                                    >
                                                </template>
                                            </v-radio>
                                        </v-radio-group>
                                    </v-col>
                                </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-switch
                                class="pl-3"
                                v-model="casoDeUso.estado"
                                text
                                color="orange darken-3"
                                :label="
                                    `${
                                        casoDeUso.estado == true
                                            ? 'ACTIVO'
                                            : 'INACTIVO'
                                    }`
                                "
                            >
                            </v-switch>
                            <v-spacer></v-spacer>
                            <v-btn color="error" text @click="dialog = false">
                                Cerrar
                            </v-btn>
                            <v-btn
                                v-if="!update"
                                color="primary"
                                @click="createCasoDeUso"
                            >
                                Guardar
                            </v-btn>
                            <v-btn
                                v-else
                                color="primary"
                                @click="updateCasoDeUso"
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
            casoDeUso: {},
            casosDeUso: [],
            itemsFuentes: [],
            loading: true,
            titleForm: null,
            search: "",
            cuentaIT: 0,
            cuentaOT: 0,
            estado: [
                { text: "HABILITADO", value: 1 },
                { text: "DESHABILITADO", value: 0 }
            ],
            headers: [
                { text: "Nombre", value: "nombre" },
                { text: "Descripcion", value: "descripcion" },
                // { text: "Resultado Esperado", value: "resultado_esperado" },
                { text: "Tipo", value: "tipo" },
                { text: "Fuentes", value: "fuentes" },
                // { text: "Escenario", value: "escenario" },
                { text: "Estado", value: "estado" },
                { text: "Acciones", sortable: false }
            ],
            selected:[],
        };
    },
    created() {
        this.intialData();
    },
    methods: {
        intialData() {
            this.axios
                .get("/api/casos-de-uso/")
                .then(response => {
                    this.casosDeUso = response.data;
                    response.data.forEach(element => {
                        if (element.tipo == "IT") this.cuentaIT++;
                        else this.cuentaOT++;
                    });
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        createCasoDeUso() {
            console.log(this.casoDeUso);
            this.loading = true;
            this.axios
                .post("/api/casos-de-uso", this.casoDeUso)
                .then(() => {
                    this.dialog = false;
                    this.intialData();
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        addCasoDeUso() {
            this.titleForm = "Nuevo Caso de Uso";
            this.casoDeUso = {};
            this.casoDeUso.estado = true;
            this.casoDeUso.tipo = "OT";
            this.itemsFuentes.push("Kaspersky");
            this.update = false;
            this.dialog = true;
        },
        editCasoDeUso(el) {
            this.titleForm = "Editar Caso de Uso";
            this.update = true;
            var auxfuentes = [];
            this.casoDeUso.id = el.id;
            this.casoDeUso.nombre = el.nombre;
            this.casoDeUso.descripcion = el.descripcion;
            this.casoDeUso.tipo = el.tipo;
            this.casoDeUso.fuentes = el.fuentes
                ? el.fuentes.split(",")
                : auxfuentes;
            this.casoDeUso.estado = el.estado == 1 ? true : false;
            this.dialog = true;
        },
        updateCasoDeUso() {
            this.loading = true;
            this.axios
                .patch(`/api/casos-de-uso/${this.casoDeUso.id}`, this.casoDeUso)
                .then(res => {
                    this.dialog = false;
                    this.intialData();
                });
        },
        deleteCasoDeUso(el) {
            this.loading = true;
            this.axios.delete(`/api/casos-de-uso/${el.id}`).then(() => {
                let i = this.casosDeUso.map(data => data.id).indexOf(el.id);
                this.casosDeUso.splice(i, 1);
                this.loading = false;
            });
        }
    }
};
</script>
