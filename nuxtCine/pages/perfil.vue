<template>
  <div>
    <Header />
    <div class="container">
      <div class="content">
        <h1 class="titulo">Entrades</h1>
        <div v-if="loading" class="loading-animation">Cargando...</div>
        <div v-else>
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
          <div v-else>
            <p>No tens entrades.</p>
          </div>
        </div>
        <div v-if="mensajeError" class="error-message">
          <p>{{ mensajeError }}</p>
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
      reservas: [],
      mensajeError: '',
      loading: false
    };
  },
  created() {
    this.fetchReservas();
  },
  methods: {
    async fetchReservas() {
      try {
        const userStore = useStore(); // Obtener el almacenamiento de Pinia
        const email = userStore.email; // Obtener el email del usuario desde el almacenamiento

        this.loading = true; // Mostrar animación de carga

        const response = await fetch(`http://tr3pol.daw.inspedralbes.cat/laravel/public/api/tickets?email=${email}`);
        if (!response.ok) {
          throw new Error('Error al buscar las reservas');
        }

        const data = await response.json();

        this.reservas = await Promise.all(data.tickets.map(async ticket => {
          const movieResponse = await fetch(`http://tr3pol.daw.inspedralbes.cat/laravel/public/api/movies/${ticket.movie_id}`);
          if (!movieResponse.ok) {
            throw new Error('Error al buscar la película');
          }
          const movieData = await movieResponse.json();
          return {
            ...ticket,
            movie_title: movieData.titol,
          };
        }));

        this.loading = false; // Ocultar animación de carga
      } catch (error) {
        console.error('Error:', error);
        this.mensajeError = error.message;
        this.loading = false; // Ocultar animación de carga
      }
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

.loading-animation {
  text-align: center;
  font-size: 1.5em;
  margin-top: 20px;
}
</style>
