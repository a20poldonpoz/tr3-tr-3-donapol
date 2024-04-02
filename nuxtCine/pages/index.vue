<template>
  <div>
    <Header />
    <div class="container">
      <div class="card">
        <div class="image">
          <img :src="recommendedMovie.img" alt="Portada de la película" />
        </div>
        <div class="content">
          <h3>{{ recommendedMovie.title }}</h3>
          <p><b>Director:</b> {{ recommendedMovie.director }}</p>
          <p><b>Año:</b> {{ recommendedMovie.any }}</p>
          <p><b>Sessió: </b>{{ recommendedMovie.hora }}</p>
          <p>{{ recommendedMovie.descripcio }}</p>
          <NuxtLink :to="'/reserva/' + recommendedMovie.id">
            <button class="reservar-button">Reservar seients</button>
          </NuxtLink>
        </div>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
export default {
  data() {
    return {
      recommendedMovie: {
        id: '',
        title: '',
        img: '',
        director: '',
        any: '',
        hora: '',
        descripcio: ''
      }
    };
  },
  methods: {
    fetchRecommendedMovie() {
      fetch("http://localhost:8000/api/movies/semana") // Endpoint para obtener la película de la semana
        .then(response => response.json())
        .then(data => {
          if (data) {
            this.recommendedMovie = data;
          } else {
            console.log("Error de fetch");
          }
        })
        .catch(error => {
          console.error("Error al obtener la película recomendada de la semana:", error);
        });
    }
  },
  mounted() {
    this.fetchRecommendedMovie();
  }
};
</script>

<style scoped>
.container {
  display: flex;
  justify-content: center;
}

.card {
  width: 300px;
  height: 400px;
  background-color: #fff;
  margin: 20px;
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
