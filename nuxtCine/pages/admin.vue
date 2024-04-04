<template>
  <div>
    <Header />
    <h1>CRUD PEL·LICULES</h1>
    <table class="movie-table">
      <thead>
        <tr>
          <th>Poster</th>
          <th>Titol</th>
          <th>Director</th>
          <th>Any</th>
          <th>Sessió</th>
          <th>Descripció</th>
          <th>Accions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="estreno in estrenos" :key="estreno.id">
          <td><img :src="estreno.img" alt="Portada de la película" class="movie-image" /></td>
          <td>
            <span v-if="!estreno.editando" @click="estreno.editando = true">{{ estreno.titol }}</span>
            <input v-else v-model="estreno.titolEditado" @keyup.enter="guardarCambios(estreno)">
          </td>
          <td>
            <span v-if="!estreno.editando" @click="estreno.editando = true">{{ estreno.director }}</span>
            <input v-else v-model="estreno.directorEditado" @keyup.enter="guardarCambios(estreno)">
          </td>
          <td>
            <span v-if="!estreno.editando" @click="estreno.editando = true">{{ estreno.any }}</span>
            <input v-else v-model="estreno.anyEditado" @keyup.enter="guardarCambios(estreno)">
          </td>
          <td>
            <span v-if="!estreno.editando" @click="estreno.editando = true">{{ estreno.hora }}</span>
            <input v-else v-model="estreno.horaEditado" @keyup.enter="guardarCambios(estreno)">
          </td>
          <td>
            <span v-if="!estreno.editando" @click="estreno.editando = true">{{ estreno.descripcio }}</span>
            <input v-else v-model="estreno.descripcioEditado" @keyup.enter="guardarCambios(estreno)">
          </td>
          <td>
            <button v-if="!estreno.editando" @click="estreno.editando = true">Editar</button>
            <button v-else @click="guardarCambios(estreno)">Guardar</button>
            <button @click="eliminarEstreno(estreno.id)">Eliminar</button>
          </td>
        </tr>
      </tbody>
    </table>
    <Footer />
  </div>
</template>

<script>
export default {
  data() {
    return {
      estrenos: [],
    };
  },
  methods: {
    fetchData() {
      fetch("http://localhost:8000/api/movies")
        .then((response) => response.json())
        .then((data) => {
          if (data) {
            this.estrenos = data.map(estreno => ({
              ...estreno,
              editando: false,
              titolEditado: estreno.titol,
              directorEditado: estreno.director,
              anyEditado: estreno.any,
              horaEditado: estreno.hora,
              descripcioEditado: estreno.descripcio
            }));
          } else {
            console.log("Error de fetch");
          }
        })
        .catch((error) => {
          console.error(error);
        });
    },
    eliminarEstreno(id) {
      if (confirm("¿Estás seguro de que quieres eliminar esta película?")) {
        fetch(`http://localhost:8000/api/movies/${id}`, {
          method: "DELETE",
        })
          .then((response) => {
            if (response.ok) {
              // Eliminación exitosa, actualiza la lista de películas
              this.fetchData();
            } else {
              console.error("Error al eliminar película");
            }
          })
          .catch((error) => {
            console.error("Error de red:", error);
          });
      }
    },
    guardarCambios(estreno) {
      fetch(`http://localhost:8000/api/movies/${estreno.id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          titol: estreno.titolEditado,
          director: estreno.directorEditado,
          any: estreno.anyEditado,
          hora: estreno.horaEditado,
          descripcio: estreno.descripcioEditado
        })
      })
      .then(response => {
        if (response.ok) {
          // Actualización exitosa, cambia el estado de edición y actualiza la lista de películas
          estreno.editando = false;
          this.fetchData();
        } else {
          console.error("Error al guardar cambios");
        }
      })
      .catch(error => {
        console.error("Error de red:", error);
      });
    }
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style lang="scss" scoped>
.movie-table {
  width: 100%;
  border-collapse: collapse;
}

.movie-table th,
.movie-table td {
  border: 1px solid #ccc;
  padding: 8px;
}

.movie-image {
  width: 80px; 
  height: auto;
}
</style>
