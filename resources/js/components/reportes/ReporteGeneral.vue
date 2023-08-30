<template>
  <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6"
                >Reporte de Contratos
            </v-card-title>

            <v-card-text>
                <v-form ref="form"
                        v-model="valid">
                        <v-row>
                                    <v-col
                                    cols="12"
                                    sm="6"
                                    >
                                        <v-btn  block color="primary" :loading="loadingUpload" dark  @click="generarReporte">Generar Reporte</v-btn>
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
        async generarReporte(){
                this.loading = true;
                this.loadingUpload=true;
                let url;
             await   this.axios
                    .get(`/api/reporte-contratos/`)
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
</script>

<style>

</style>
