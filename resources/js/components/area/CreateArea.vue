<template >
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h5 class="card-title">Nueva Area</h5>
    </div>
    <div class="card-body">
      <form @submit.prevent="addArea">
        <div class="row">
          <div class="col-sm-4">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre del area:</label>
              <input
                type="text"
                class="form-control"
                v-model="area.nombre"
                required
              />
            </div>
          </div>
          <div class="col-sm-4">
            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripcion:</label>
              <input
                type="text"
                class="form-control"
                v-model="area.descripcion"
                required
              />
            </div>
          </div>
          <div class="col-sm-4">
            <div class="mb-3">
              <label for="estado" class="form-label">Estado:</label>
              <input
                type="text"
                class="form-control"
                v-model="area.estado"
                required
              />
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      area: {},
    };
  },
  methods: {
    addArea() {
      this.axios
        .post("http://localhost:8000/api/areas", this.area)
        .then((response) => this.$router.push({ name: "areas" }))
        .catch((err) => console.log(err))
        .finally(() => (this.loading = false));
    },
  },
};
</script>
