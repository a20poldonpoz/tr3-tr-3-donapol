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
            <span>{{ estreno.titol }}</span>
          </td>
          <td>
            <span>{{ estreno.director }}</span>
          </td>
          <td>
            <span>{{ estreno.any }}</span>
          </td>
          <td>
            <span>{{ estreno.hora }}</span>
          </td>
          <td>
            <span>{{ estreno.descripcio }}</span>
          </td>
          <td>
            <button class="delete-button" @click="eliminarEstreno(estreno.id)">Eliminar</button>
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
              this.estrenos = this.estrenos.filter(estreno => estreno.id !== id);
            } else {
              console.error("Error al eliminar película");
            }
          })
          .catch((error) => {
            console.error("Error de red:", error);
          });
      }
    },
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

.edit-button {
  background-color: blue;
  color: white;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
}

.delete-button {
  background-color: red;
  color: white;
  border: none;
  padding: 5px 10px;
  cursor: pointer;
}
</style>
