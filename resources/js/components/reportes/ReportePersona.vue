<template>
  <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6"
                >Reporte por Persona
            </v-card-title>

            <v-card-text>
                <v-form ref="form"
                        v-model="valid"
                        lazy-validation>
                        <v-row>
                            <v-col
                            cols="12"
                             md="6"
                            >
                            <v-autocomplete

                                clearable
                                :items="personas"

                                item-text="persona_nombre"
                                item-value="id"
                                v-model="persona"
                                label="Seleccione una persona"
                                dense
                                return-object
                                :rules="Rules.persona"
                                required

                            >
                            </v-autocomplete>

                            </v-col>
                            <v-col cols="12" md="6">
                             <v-btn  block color="primary" :loading="loadingUpload" :disabled="!valid"  dark  @click="generarReporte">Generar Reporte</v-btn>
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
            personas: [],
            persona:{},
            loading: false,
            loadingUpload: false,
            a:null,
            valid: true,
             Rules : {
                persona: [
                    v => !!v || 'Este campo es requerido'
                ],
             }
        };
    },
    created() {
         this.axios.get("/api/persona/").then(response => {
                    this.personas = response.data;
                    for (const iterator of this.personas) {
                        iterator.persona_nombre = iterator.nombre+' '+iterator.apellido
                    }
                    console.log(response.data);
                });


    },
    computed:{
        personaNombre(elem){
            return elem.nombre+' '+elem.apellido
        }
    },
    methods: {

        async generarReporte(){
            if (this.$refs.form.validate()) {
                this.loading = true;
                this.loadingUpload=true;
                let url;
             await   this.axios
                    .get(`/api/reporte-persona/${this.persona.id}`)
                    .then(response => {
                        url=response.config.baseURL+response.config.url;

                    }).catch((error)=>(console.log(error)));

                    this.loading = false;
                    this.loadingUpload=false;
                    //this.dates = [];
                    this.valid = true;
                    window.open(url,'_blank');
            }else{
                alert("invalido")
            }


        }
    }
}
</script>


