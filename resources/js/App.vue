<template>
 <div class="container-fluid px-0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav" v-if="$store.state.auth">
        <li class="nav-item">
          <router-link to="/usuarios" class="nav-item nav-link">Usuarios</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/areas" class="nav-item nav-link">Areas</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/clientes" class="nav-item nav-link">Clientes</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/contratos" class="nav-item nav-link">Contratos</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/tareas" class="nav-item nav-link">Tareas</router-link>
        </li>



      </ul>
      <ul class="navbar-nav ml-auto">
            <template v-if="$store.state.auth">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                        {{ $store.state.user.name  }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                        <a class="dropdown-item"
                            @click="logout">
                            Salir
                        </a>
                    </div>
                </li>

        </template>
        <template v-else>
            <li class="nav-item">
                <router-link to="/login" class="nav-link">Login</router-link>
            </li>
        </template>
        </ul>
    </div>
</nav>
    <div class="row pt-4 px-2">
            <div class="col-12">
            <router-view> </router-view>
            </div>
        </div>
  </div>
<!-- <div>
    <v-app-bar
      color="deep-purple accent-4"
      dense
      dark
    >
      <v-app-bar-nav-icon></v-app-bar-nav-icon>

      <v-toolbar-title>Page title</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>mdi-heart</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>

      <v-menu
        left
        bottom
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            icon
            v-bind="attrs"
            v-on="on"
          >
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-item
            v-for="n in 5"
            :key="n"
            @click="() => {}"
          >
            <v-list-item-title>Option {{ n }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
  </div> -->
</template>

<script>
    export default {
        methods:{
            async logout(){
              await  this.$store.dispatch("logout");
              this.$router.replace("/login");
            }
        }
    }
</script>
