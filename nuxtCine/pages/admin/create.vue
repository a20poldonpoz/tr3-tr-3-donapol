<template>
  <div>
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
      try {
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
          this.$router.push('/crud');
        } else {
          console.error('Error al crear película:', response.statusText);
        }
      } catch (error) {
        console.error('Error al crear película:', error);
      }
    }
  }, 
  beforeMount() {
    const store = useStore();
    this.tipusUsuari = store.returnTipus();
    if(this.tipusUsuari !== 'admin') {
      this.$router.push('/'); // Si el usuario no es administrador, redirige a otra página
    }
  }
};
</script>

<style scoped>
/* Estilos específicos del componente */
</style>
