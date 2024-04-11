<template>
  <body>
    <div>
      <Header />

      <div class="title-container">
        <h1>CRUD PEL·LICULES</h1>
        <router-link to="/admin/createSeients">
          <button class="seient-button">Crear Seients</button>
        </router-link>
      </div>

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
              <button class="create-button" @click="crearPelicula()">Crear Película</button>
              <button v-if="estreno.editando" @click="guardarEdicion(estreno)" class="guardar-button">Guardar</button>
              <button v-if="estreno.editando" @click="cancelarEdicion(estreno)" class="cancelar-button">Cancelar</button>
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
      },
      tipusUsuari: null
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
    crearPelicula() {
      navigateTo('/admin/create');
    },
    eliminarEstreno(id) {
      if (confirm("¿Estás segur de que vols eliminar la película?")) {
        fetch(`http://localhost:8000/api/movies/${id}`, {
          method: "DELETE",
        })
          .then((response) => {
            this.estrenos = this.estrenos.filter(estreno => estreno.id !== id);
          })
          .catch((error) => {
            console.error("Error de red:", error);
          });
      }
    },
    editarEstreno(estreno) {
      estreno.editando = true;
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
          //Actualitzar les dades de la sessio
          const index = this.estrenos.findIndex(item => item.id === data.id);
          this.estrenos.splice(index, 1, data);
          //Cancelar dades
          this.cancelarEdicion(estreno);
        });
    },
    cancelarEdicion(estreno) {
      //Deijar el formulari com estaba
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
  beforeMount() {
    const store = useStore();
    this.tipusUsuari = store.returnTipus();
    if (this.tipusUsuari !== 'admin') {
      this.$router.push('/'); // Si el usuario no es administrador, redirige a otra página
    }
  }
};
</script>

<style lang="css" scoped>
body {
  margin: 0;
  padding: 0;
  height: 100vh;
}

.title-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.title {
  margin: 0;
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
  border-radius: 3px;
  padding: 5px 10px;
  margin: 3px;
  cursor: pointer;
}

.create-button {
  background-color: rgb(174, 0, 255);
  color: white;
  border-radius: 3px;
  padding: 5px 10px;
  margin: 3px;
  cursor: pointer;
}

.delete-button {
  background-color: red;
  color: white;
  border-radius: 3px;
  border-color: black;
  padding: 5px 10px;
  margin: 3px;
  cursor: pointer;
}

.seient-button {
  background-color: orange;
  color: white;
  border-radius: 5px;
  border-color: black;
  padding: 20px 20px;
  margin: 10px;
  cursor: pointer;
  font-size: 18px;
}

.guardar-button {
  background-color: rgb(21, 255, 0);
  color: black;
  padding: 5px 10px;
  margin: 3px;
  cursor: pointer;
}

.cancelar-button {
  background-color: red;
  color: black;
  padding: 5px 10px;
  margin: 3px;
  cursor: pointer;
}
</style>
