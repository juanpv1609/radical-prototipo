<template>
  <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6"
                >Reporte de Tareas
            </v-card-title>

            <v-card-text>
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
                                width="400"
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
                            ></v-text-field>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                                <v-btn  block color="primary" dark  @click="generarReporte">Generar Reporte</v-btn>
                            </v-col>

                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
  </div>
</template>

<script>
export default {
     data() {
        return {

            loading: false,
            filtro: {},
            dates: ['2021-05-01','2022-03-25'],
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
            console.log(this.dates);
                    this.loading = true;

            this.axios
                .get(`/api/reporte-tareas/${this.dates[0]}/${this.dates[1]}`)
                .then(response => {
                    const url=response.config.baseURL+response.config.url;
                    window.open(url,'_blank');
                    this.loading = false;
                }).catch((error)=>(console.log(error)));
        }
    }
}
</script>

<style>

</style>
