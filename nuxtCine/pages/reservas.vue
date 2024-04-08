<template>
  <body>
    <Header />
    <div class="container">
      <div class="content">
        <h1 class="titulo">Les meves sessions</h1>
        <input type="email" placeholder="Ingrese su correo electrónico" v-model="email" class="input-email">
        <button @click="buscarReservas" class="buscar-button">Buscar Reservas</button>
        <div v-if="reservas.length > 0">
          <ul>
            <li v-for="(reserva, index) in reservas" :key="index" class="reserva-item">
              <p class="pelicula">Película: {{ reserva.movie_title }}</p>
              <p class="sala">Sala: {{ reserva.movie_id }}</p>
              <p class="preu">Preu: {{ reserva.preu }}</p>
            </li>
          </ul>
        </div>
        <div v-if="mensajeError" class="error-message">
          <p>{{ mensajeError }}</p>
        </div>
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
  height: 100vh;
  display: flex;
  flex-direction: column;
}

.container {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.content {
  padding: 20px;
  max-width: 600px;
  width: 100%;
}

.input-email {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  margin-bottom: 10px;
}

.buscar-button {
  width: 100%;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

.titulo {
  font-size: 24px;
  margin-bottom: 20px;
}

.reserva-item {
  background-color: #f9f9f9;
  border-radius: 5px;
  padding: 15px;
  margin-bottom: 10px;
}

.pelicula {
  font-size: 18px;
  margin-bottom: 5px;
}

.sala {
  font-size: 16px;
  color: #777;
}

.preu {
  font-size: 16px;
  color: #777;
}

.error-message {
  color: red;
  margin-top: 20px;
}
</style>
