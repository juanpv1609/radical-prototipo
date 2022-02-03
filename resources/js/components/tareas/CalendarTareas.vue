<template>

<v-card elevation="2" >
    <v-tabs
      dark
      show-arrows
    >
      <v-tabs-slider color="orange darken-4"></v-tabs-slider>

      <v-tab
        v-for="item in clientes"
        :key="item.id"
        @click="getEntregables(item)"
      >
        {{ item.nombre_comercial }}
      </v-tab>
    </v-tabs>
        <v-card-title >

            {{ nombreCliente }}
            <v-spacer></v-spacer>
            <v-btn
                    fab
                    small :to="{
                                    name: 'tareas'}">
                    <v-icon >mdi-table</v-icon>
                </v-btn>
        </v-card-title>
        <v-card-text>
            <v-row class="fill-height">
                <v-col>
                <v-sheet height="64">
                    <v-toolbar
                    flat
                    >
                    <v-btn
                        outlined
                        class="mr-4"
                        color="grey darken-2"
                        @click="setToday"
                    >
                        Hoy
                    </v-btn>
                    <v-btn
                        fab
                        text
                        small
                        color="grey darken-2"
                        @click="prev"
                    >
                        <v-icon small>
                        mdi-chevron-left
                        </v-icon>
                    </v-btn>
                    <v-btn
                        fab
                        text
                        small
                        color="grey darken-2"
                        @click="next"
                    >
                        <v-icon small>
                        mdi-chevron-right
                        </v-icon>
                    </v-btn>
                    <v-toolbar-title v-if="$refs.calendar">
                        {{ $refs.calendar.title }}
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-menu
                        bottom
                        right
                    >
                        <template v-slot:activator="{ on, attrs }">
                        <v-btn
                            outlined
                            color="grey darken-2"
                            v-bind="attrs"
                            v-on="on"
                        >
                            <span>{{ typeToLabel[type] }}</span>
                            <v-icon right>
                            mdi-menu-down
                            </v-icon>
                        </v-btn>
                        </template>
                        <v-list>
                        <v-list-item @click="type = 'day'">
                            <v-list-item-title>Dia</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="type = 'week'">
                            <v-list-item-title>Semana</v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="type = 'month'">
                            <v-list-item-title>Mes</v-list-item-title>
                        </v-list-item>
                        </v-list>
                    </v-menu>
                    </v-toolbar>
                </v-sheet>
                <v-sheet height="700">
                    <v-calendar
                    ref="calendar"
                    v-model="focus"
                    color="primary"
                    :events="events"
                    :event-color="getEventColor"
                    :type="type"
                    @click:event="showEvent"
                    @click:more="viewDay"
                    @click:date="viewDay"
                    @change="updateRange"
                    ></v-calendar>
                    <v-menu
                    v-model="selectedOpen"
                    :close-on-content-click="false"
                    :activator="selectedElement"
                    offset-x
                    >
                    <v-card
                        color="grey lighten-4"
                        min-width="300px"
                        flat
                    >
                        <v-toolbar
                        :color="selectedEvent.color"
                        dark
                        >
                        <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon>
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        </v-toolbar>
                        <v-card-text>
                        <span v-html="selectedEvent.details"></span>
                        </v-card-text>
                        <v-card-actions>
                        <v-btn
                            text
                            :color="selectedEvent.color"
                            @click="selectedOpen = false"
                        >
                            Cerrar
                        </v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-menu>
                </v-sheet>
                </v-col>
            </v-row>
        </v-card-text>
</v-card>
</template>
<script>
  export default {
    data: () => ({
        //TAREAS
    tareas: [],
    tareas_email: [],
    alertas:0,
        //------
        today:null,
      focus: '',
      type: 'month',
      typeToLabel: {
        month: 'Mes',
        week: 'Semana',
        day: 'Dia',
      },
      selectedEvent: {},
      selectedElement: null,
      selectedOpen: false,
      events: [],
      clientes: [],
      nombreCliente:null
    }),
    mounted () {
      this.$refs.calendar.checkChange()
    },
    created(){
         /* this.axios
                .get('/api/tareas')
                .then(response => {
                    this.tareas = response.data;
                    this.updateRange();
                    console.log(this.tareas);
                    this.loading = false;
                }); */
                this.initialData();
    },
    methods: {
        initialData(){
            this.axios
                .get('/api/clientes')
                .then(response => {
                    this.clientes = response.data;
                    //console.log(this.clientes);
                    this.getEntregables(this.clientes[0]);
                });
        },
        getEntregables(cliente){
            //console.log(cliente);
            this.nombreCliente=cliente.nombre_comercial
            this.loading=true;
             this.axios
                .get(`/api/tareas-cliente/${cliente.id}`)
                .then(response => {
                    this.tareas = response.data;
                    this.updateRange();
                    console.log(this.tareas);
                    this.loading = false;
                });

        },
      viewDay ({ date }) {
        this.focus = date
        this.type = 'day'
      },
      getEventColor (event) {
        return event.color
      },
      setToday () {
        this.today = new Date();
        console.log(this.today);
        this.focus = this.today.toLocaleDateString();
        this.type = 'day'
      },
      prev () {
        this.$refs.calendar.prev()
      },
      next () {
        this.$refs.calendar.next()
      },
      showEvent ({ nativeEvent, event }) {
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          setTimeout(() => {
            this.selectedOpen = true
          }, 10)
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          setTimeout(open, 10)
        } else {
          open()
        }

        nativeEvent.stopPropagation()
      },
      updateRange () {
          const events = []
            for (const item of this.tareas) {
            const allDay = this.rnd(0, 3) === 0

            events.push({
                name: item.descripcion,
                start: item.fecha,
                end: item.fecha,
                color: item.estado_tarea.color,
                timed: !allDay,
                details: `Fecha de entrega: ${item.fecha}<br>
                            Responsable: ${item.usuario.name}<br>
                        Cliente: ${item.contrato.cliente.nombre_comercial} <br>
                        Ticket: ${item.ticket} <br>
                        Estado: ${item.estado_tarea.descripcion}`,
            })
            }

        this.events = events
      },
      rnd (a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
    },
  }
</script>
