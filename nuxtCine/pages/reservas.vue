<template>
  <body>
    <Header />
  <div>
    <input type="email" placeholder="Ingrese su correo electrónico" v-model="email">
    <button @click="buscarReservas">Buscar Reservas</button>
    <div v-if="reservas.length > 0">
      <h1>Les teves sessions</h1>
      <ul>
        <li v-for="(reserva, index) in reservas" :key="index">
          <p>Película: {{ reserva.movie_title }}</p>
          <p>Sala: {{ reserva.movie_id }}</p>
        </li>
      </ul>
    </div>
    <div v-if="mensajeError">
      <p>{{ mensajeError }}</p>
    </div>
  </div>
  <Footer />
</body>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      reservas: [],
      mensajeError: ''
    };
  },
  methods: {
    buscarReservas() {
      fetch(`http://localhost:8000/api/tickets?email=${this.email}`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Error al buscar las reservas');
          }
          return response.json();
        })
        .then(data => {
          this.reservas = data.tickets.map(ticket => {
            return {
              ...ticket,
              movie_title: '',
            };
          });

          const fetchMovies = this.reservas.map(ticket => {
            return fetch(`http://localhost:8000/api/movies/${ticket.movie_id}`)
              .then(response => {
                if (!response.ok) {
                  throw new Error('Error al buscar la película');
                }
                return response.json();
              })
              .then(movieData => {
                ticket.movie_title = movieData.titol;
              })
              .catch(error => {
                console.error(error.message);
              });
          });

          Promise.all(fetchMovies)
            .then(() => {
              console.log('Fetch completado');
            })
            .catch(error => {
              console.error('Error en el fetch:', error.message);
            });
        })
        .catch(error => {
          this.mensajeError = error.message;
        });
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
</style>
