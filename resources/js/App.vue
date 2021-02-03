<template>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <!-- <router-link to="/" class="nav-item nav-link">Products List</router-link> -->
                    <router-link to="/clientes" class="nav-item nav-link">Clientes</router-link>
                    <router-link to="/contratos" class="nav-item nav-link">Contratos</router-link>
                    <!-- <router-link to="/create" class="nav-item nav-link">Create Product</router-link> -->
                </div>
            </div>
        </nav>

        <router-view> </router-view>
    </div>
</template>

<script>
    export default {}
</script>
