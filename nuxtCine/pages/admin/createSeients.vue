<template>
  <body>
    <div>
      <Header />
      <div class="container">
        <h1>Crear Asientos</h1>
        <form @submit.prevent="crearAsientos">
          <div>
            <label for="pelicula">Película:</label>
            <select id="pelicula" v-model="formulari.pelicula" required>
              <option value="">Selecciona una película</option>
              <option v-for="pelicula in peliculas" :key="pelicula.id" :value="pelicula.id">{{ pelicula.titol }}</option>
            </select>
          </div>
          <div>
            <label for="vip">Fila VIP:</label>
            <input type="number" id="vip" v-model="formulari.filaVip" required>
          </div>
          <button type="submit">Crear Asientos</button>
        </form>
      </div>
      <Footer />
    </div>
  </body>
</template>

<script>
export default {
  data() {
    return {
      formulari: {
        pelicula: '',
        filaVip: ''
      },
      peliculas: []
    };
  },
  methods: {
    async cargarPeliculas() {
      try {
        const response = await fetch('http://localhost:8000/api/movies');
        if (response.ok) {
          this.peliculas = await response.json();
        } else {
          console.error('Error al cargar películas:', response.statusText);
        }
      } catch (error) {
        console.error('Error al cargar películas:', error);
      }
    },
    async crearAsientos() {

      const response = await fetch('http://localhost:8000/api/seats/generate', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          movie_id: this.formulari.pelicula,
          fila_vip: this.formulari.filaVip
        })
      });
      if (response.ok) {
        this.$router.push('crud');
      } else {
        console.error('Error al crear asientos:', response.statusText);
      }
    }
  },
  mounted() {
    this.cargarPeliculas();
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

<style scoped>
body {
  margin: 0;
  padding: 0;
  height: 100%;
}

.container {
  max-width: 400px;
  margin: 20px auto;
  padding: 20px;
  margin-bottom: 192px;
  margin-top: 100px;
  border: 2px solid #ccc;
  border-radius: 8px;
  box-shadow: 0 0 20px rgba(221, 203, 38, 0.74);
}

form {
  display: grid;
  gap: 10px;
}

label {
  font-weight: bold;
}

input[type="text"],
input[type="number"] {
  width: 100%;
  padding: 9px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

button[type="submit"] {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button[type="submit"]:hover {
  background-color: #0056b3;
}

h1 {
  font-size: 24px;
  margin-bottom: 22px;
  text-align: center;
}

button[type="submit"] {
  margin-top: 10px;
}
</style>
