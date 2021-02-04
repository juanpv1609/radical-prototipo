<template>
    <div class="container-fluid px-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <!-- <router-link to="/" class="nav-item nav-link">Products List</router-link> -->
                    <router-link to="/areas" class="nav-item nav-link">Areas</router-link>
                    <router-link to="/clientes" class="nav-item nav-link">Clientes</router-link>
                    <router-link to="/contratos" class="nav-item nav-link">Contratos</router-link>
                    <!-- <router-link to="/create" class="nav-item nav-link">Create Product</router-link> -->
                </div>
            </div>
        </nav>
    <div class="row pt-4 px-2">
        <div class="col-12">
        <router-view> </router-view>
        </div>
    </div>
    </div>
</template>

<script>
    export default {}
</script>
