<template>
  <body>

  <div>
    <Header />
    <h1 class="title">TOP PEL·LÍCULES</h1>
    <div class="container">
      <div v-for="movie in movies" :key="movie.id" class="card">
        <div class="image">
          <img :src="movie.img" alt="Portada de la película" />
        </div>
        <div class="content">
          <h3>{{ movie.title }}</h3>
          <p><b>Director:</b> {{ movie.director }}</p>
          <p><b>Any:</b> {{ movie.any }}</p>
          <NuxtLink :to="'/reserva/' + movie.id">
            <button class="reservar-button">Reservar seients</button>
          </NuxtLink>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</body>
</template>

<script>
export default {
  data() {
    return {
      movies: [], 
    };
  },
  methods: {
    fetchMovies() {
      // Realizar una solicitud para obtener todas las películas disponibles
      fetch("http://localhost:8000/api/movies")
        .then(response => response.json())
        .then(data => {
          if (data) {
            // Aleatorizar el orden de las películas
            const shuffledMovies = this.shuffleArray(data);
            // Obtener las primeras cuatro películas
            this.movies = shuffledMovies.slice(0, 4);
          } else {
            console.log("Error de fetch");
          }
        })
        .catch(error => {
          console.error("Error al obtener las películas:", error);
        });
    },
    // Función para aleatorizar el orden de un array
    shuffleArray(array) {
      let currentIndex = array.length,  randomIndex;

      // Mientras haya elementos restantes a mezclar
      while (currentIndex != 0) {
        // Elegir un elemento restante
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // Intercambiar el elemento restante con el actual
        [array[currentIndex], array[randomIndex]] = [
          array[randomIndex], array[currentIndex]];
      }

      return array;
    }
  },
  mounted() {
    this.fetchMovies();
    // Agregar una clase al body para ocultar el overflow vertical
    document.body.classList.add('no-scroll');
  },
  beforeDestroy() {
    // Remover la clase del body al salir del componente para permitir el scroll nuevamente
    document.body.classList.remove('no-scroll');
  }
};
</script>

<style scoped>
body{
  margin: 0;
  padding: 0;
  height: 100%;
}
.title {
  text-align: center;
}

.container {
  display: flex;
  justify-content: center;
}

.card {
  width: 300px; 
  height: 400px; 
  background-color: #fff;
  margin: 20px;
  margin-bottom: 40px;
  overflow: hidden;
  border-radius: 15px;
  transition: 0.3s ease-in-out;
  position: relative;
}

.card:hover {
  height: 400px; 
}

.card .image img {
  width: 100%;
  height: auto;
  border-radius: 15px;
  transition: transform 0.3s ease-in-out; 
}

.card:hover .image img {
  transform: scale(1.4); 
}

.card .content {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  padding: 20px;
  box-sizing: border-box;
  transform: translateY(100%); 
  transition: transform 0.3s ease-in-out; 
}

.card:hover .content {
  transform: translateY(0); 
}

h3 {
  margin-top: 0;
  margin-bottom: 10px;
  font-size: 1.5rem;
}

p {
  margin: 0;
  font-size: 1rem;
}

.reservar-button {
  margin-top: 10px;
  cursor: pointer;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  font-size: 1rem;
  transition: background-color 0.3s ease-in-out;
}

.reservar-button:hover {
  background-color: #0056b3;
}
</style>
