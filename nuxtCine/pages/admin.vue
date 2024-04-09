<template>
  <body>
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
            <td v-if="!estreno.editando">
              <span>{{ estreno.titol }}</span>
            </td>
            <td v-else>
              <input v-model="formularioEdicion.titol" type="text">
            </td>
            <td v-if="!estreno.editando">
              <span>{{ estreno.director }}</span>
            </td>
            <td v-else>
              <input v-model="formularioEdicion.director" type="text">
            </td>
            <td v-if="!estreno.editando">
              <span>{{ estreno.any }}</span>
            </td>
            <td v-else>
              <input v-model="formularioEdicion.any" type="number">
            </td>
            <td v-if="!estreno.editando">
              <span>{{ estreno.hora }}</span>
            </td>
            <td v-else>
              <input v-model="formularioEdicion.hora" type="text">
            </td>
            <td v-if="!estreno.editando">
              <span>{{ estreno.descripcio }}</span>
            </td>
            <td v-else>
              <input v-model="formularioEdicion.descripcio" type="text">
            </td>
            <td>
              <button class="delete-button" @click="eliminarEstreno(estreno.id)">Eliminar</button>
              <button class="edit-button" @click="editarEstreno(estreno)">Editar</button>
              <button v-if="estreno.editando" @click="guardarEdicion(estreno)">Guardar</button>
              <button v-if="estreno.editando" @click="cancelarEdicion(estreno)">Cancelar</button>
            </td>
          </tr>
        </tbody>
      </table>
      <Footer />
    </div>
  </body>
</template>

<script>
export default {
  data() {
    return {
      estrenos: [],
      formularioEdicion: {
        id: null,
        titol: '',
        director: '',
        any: null,
        hora: '',
        descripcio: ''
      }
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
    editarEstreno(estreno) {
      // Marcar el estreno como editando
      estreno.editando = true;
      // Copiar los datos del estreno al formulario de edición
      this.formularioEdicion = {
        ...estreno
      };
    },
    guardarEdicion(estreno) {
      fetch(`http://localhost:8000/api/movies/${estreno.id}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(this.formularioEdicion)
      })
      .then(response => response.json())
      .then(data => {
        // Actualizar los datos del estreno editado en la lista
        const index = this.estrenos.findIndex(item => item.id === data.id);
        this.estrenos.splice(index, 1, data);
        // Restablecer el formulario de edición y marcar el estreno como no editando
        this.cancelarEdicion(estreno);
      })
      .catch(error => {
        console.error("Error al actualizar película:", error);
      });
    },
    cancelarEdicion(estreno) {
      // Restablecer el formulario de edición y marcar el estreno como no editando
      this.formularioEdicion = {
        id: null,
        titol: '',
        director: '',
        any: null,
        hora: '',
        descripcio: ''
      };
      estreno.editando = false;
    }
  },
  mounted() {
    this.fetchData();
  },
};
</script>

<style lang="css" scoped>

body {
  margin: 0;
  padding: 0;
  height: 100vh;
}

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
