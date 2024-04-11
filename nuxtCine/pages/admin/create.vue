<template>
  <Header />
  <div class="container">
    <h1>Crear Película</h1>
    <form @submit.prevent="crearPelicula">
      <div>
        <label for="titol">Titol:</label>
        <input type="text" id="titol" v-model="formulari.titol" required>
      </div>
      <div>
        <label for="director">Director:</label>
        <input type="text" id="director" v-model="formulari.director" required>
      </div>
      <div>
        <label for="any">Any:</label>
        <input type="number" id="any" v-model="formulari.any" required>
      </div>
      <div>
        <label for="hora">Hora:</label>
        <input type="time" id="hora" v-model="formulari.hora" required>
      </div>
      <div>
        <label for="descripcio">Descripció:</label>
        <textarea id="descripcio" v-model="formulari.descripcio" required></textarea>
      </div>
      <button type="submit">Crear Nova Pel·lícula</button>
    </form>
  </div>
  <Footer />
</template>

<script>
export default {
  data() {
    return {
      formulari: {
        titol: '',
        director: '',
        any: null,
        hora: '',
        descripcio: ''
      }
    };
  },
  methods: {
    async crearPelicula() {
      const response = await fetch('http://localhost:8000/api/movies', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.formulari)
      });
      if (response.ok) {
        const data = await response.json();
        console.log('Película creada:', data);
        this.$router.push('crud');
      } else {
        console.error('Error al crear película:', response.statusText);
      }
    }

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
  height: 100vh;
}

.container {
  max-width: 400px;
  margin: 20px auto;
  padding: 20px;
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
input[type="number"],
input[type="time"],
textarea {
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
