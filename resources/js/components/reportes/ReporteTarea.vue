<template>
  <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6"
                >Reporte de Tareas
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
                            <v-text-field
                                v-model="dateRangeText"
                                label="Rango de fechas"
                                prepend-icon="mdi-calendar"
                                readonly
                                :rules="dateRules"
                            ></v-text-field>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                                <v-btn  block color="primary" :loading="loadingUpload" dark  @click="generarReporte">Generar Reporte</v-btn>
                            </v-col>

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

            loading: false,
            loadingUpload: false,
            dates: [],
            valid: true,
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


    },
    methods: {
        generarReporte(){
            if (this.$refs.form.validate()) {
                this.loading = true;
                this.loadingUpload=true;
                this.axios
                    .get(`/api/reporte-tareas/${this.dates[0]}/${this.dates[1]}`)
                    .then(response => {
                        const url=response.config.baseURL+response.config.url;
                        window.open(url,'_blank');
                        this.loading = false;
                        this.loadingUpload=false;
                        this.dates = [];
                    }).catch((error)=>(console.log(error)));
            }

        }
    }
}
</script>

<style>

</style>
