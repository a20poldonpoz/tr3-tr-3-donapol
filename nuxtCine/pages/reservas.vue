<template>
  <body>
    <Header />
    <div class="container">
      <div class="content">
        <h1 class="titulo">Les meves sessions</h1>
        <input type="email" placeholder="Introdueix el correu" v-model="email" class="input-email" :class="{ 'loading-animation': loading }">
        <button @click="buscarReservas" class="buscar-button">Buscar Reservas</button>
        <div v-if="reservas.length > 0" class="grid-container">
          <div v-for="(reserva, index) in reservas" :key="index" class="reserva-ticket">
            <div class="ticket">
              <div class="ticket-header">
                <h2 class="pelicula">{{ reserva.movie_title }}</h2>
              </div>
              <div class="ticket-body">
                <p class="sala">Sala: {{ reserva.movie_id }}</p>
                <p class="sala">Fila: {{ reserva.fila }} - Columna: {{ reserva.columna }}</p>
                <p class="preu">Preu: {{ reserva.preu }}</p>
              </div>
            </div>
          </div>
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
      mensajeError: '',
      loading: false
    };
  },
  methods: {
    buscarReservas() {
      this.loading = true; // Mostrar animación de carga
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
              this.loading = false; // Ocultar animación de carga
            })
            .catch(error => {
              console.error('Error en el fetch:', error.message);
              this.loading = false; // Ocultar animación de carga
            });
        })
        .catch(error => {
          this.mensajeError = error.message;
          this.loading = false; // Ocultar animación de carga
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
  background-color: #ffffff; 
  border-radius: 10px; 
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 2fr));
  grid-gap: 20px;
}

.input-email {
  width: calc(100% - 20px); 
  padding: 10px;
  font-size: 16px;
  margin-bottom: 20px;
  border: 1px solid #ccc; 
  border-radius: 5px; 
}

.buscar-button {
  width: calc(100% - 20px); 
  padding: 20px;
  background-color: #393a39;
  color: yellow;
  border: none;
  border-radius: 5px; 
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s; 
  margin-bottom: 15px;
}

.buscar-button:hover {
  background-color: #393a39; 
}

.titulo {
  font-size: 24px;
  margin-bottom: 20px;
}

.reserva-ticket {
  list-style-type: none;
}

.ticket {
  border: 1px solid #ccc;
  border-radius: 10px;
  padding: 10px;
  margin-bottom: 20px;
}

.ticket-header {
  background-color: #393a39; 
  color: yellow;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
  padding: 10px;
}

.pelicula {
  margin: 0;
}

.ticket-body {
  padding: 10px;
}

.sala,
.preu {
  margin: 5px 0;
  font-size: 16px;
  color: #777;
}

.error-message {
  color: red;
  margin-top: 20px;
}
</style>
