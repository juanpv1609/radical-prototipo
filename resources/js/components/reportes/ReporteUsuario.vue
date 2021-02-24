<template>
  <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6"
                >Reporte de Tareas por Usuario
            </v-card-title>

            <v-card-text>
                <v-form ref="form"
                        v-model="valid"
                        lazy-validation>
                        <v-row>
                    <v-col cols="12">
                        <v-row>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-date-picker
                                v-model="dates"
                                range
                                width="500"

                            ></v-date-picker>
                            </v-col>


                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-row>
                                <v-col
                            cols="12"

                            >
                            <v-select :items="usuarios"
                                            v-model="usuario"
                                                label="Seleccione un Responsable"
                                                :rules="responsableRules"
                                                >
                                            <template slot="selection" slot-scope="data">
                                                <!-- HTML that describe how select should render selected items -->
                                                {{ data.item.name }}
                                            </template>
                                            <template slot="item" slot-scope="data">
                                                <!-- HTML that describe how select should render items when the select is open -->
                                                {{ data.item.name }}
                                            </template>
                                        </v-select>
                            </v-col>
                                <v-col cols="12" >
                                    <v-text-field
                                v-model="dateRangeText"
                                label="Rango de fechas"
                                prepend-icon="mdi-calendar"

                                :rules="dateRules"
                            ></v-text-field>
                                </v-col>


                                <v-btn  block color="primary" :loading="loadingUpload" dark  @click="generarReporte">Generar Reporte</v-btn>
                            </v-row>


                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
                        </v-form>


            </v-card-text>
        </v-card>
  </div>
</template>

<script>
export default {
     data() {
        return {
            usuarios: [],
            usuario:null,

            loading: false,
            loadingUpload: false,
            dates: [],
            valid: true,
            responsableRules: [
                 v => !!v || 'Responsable is required',
             ],
            dateRules: [
                 v => !!v || 'Date range is required',
             ],
        };
    },
    computed: {
      dateRangeText () {
        return this.dates.join(' ~ ')
      },
    },
    created() {
        this.axios
                .get('/api/usuarios-all')
                .then(response => {
                    this.usuarios = response.data;
                });

    },
    methods: {
        async generarReporte(){
            if (this.$refs.form.validate()) {
                this.loading = true;
                this.loadingUpload=true;
                let url;
             await   this.axios
                    .get(`/api/reporte-tareas-usuario/${this.dates[0]}/${this.dates[1]}/${this.usuario.id}`)
                    .then(response => {
                        url=response.config.baseURL+response.config.url;

                    }).catch((error)=>(console.log(error)));

                    this.loading = false;
                    this.loadingUpload=false;
                    this.dates = [];
                    this.valid = true;
                    window.open(url,'_blank');
            }

        }
    }
}
</script>

<style>

</style>
