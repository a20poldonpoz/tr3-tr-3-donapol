<template>
  <header class="header">
    <div class="logo" @click="goToHome">
      <img src="../public/img/logo.PNG" alt="Logo" />
    </div>
    <nav class="nav">
      <ul>
        <li><nuxt-link to="/cartelera" class="button secondary">Cartelera</nuxt-link></li>
        <li><nuxt-link v-if="!loguejat" to="/login" class="button primary">Login/Registre</nuxt-link></li>
        <li><nuxt-link v-if="loguejat" :to="`/${nom_usuari}`" class="button primary">{{ nom_usuari }}</nuxt-link></li>
        <li><nuxt-link v-if="loguejat && admin" to="/admin" class="button primary">Admin</nuxt-link></li>
        <li><nuxt-link v-if="loguejat" to="/" @click="logout" class="button primary">Logout</nuxt-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
import { useStore } from '../stores/index.js';

export default {
  data() {
    return {
      loguejat: false, // Variable para indicar si el usuario está autenticado
      nom_usuari: null, // Variable para almacenar el nombre de usuario autenticado
      admin: false // Variable para indicar si el usuario es administrador
    };
  },
  methods: {
    async fetchLogin() {
      try {
        const response = await fetch('http://localhost:8000/api/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password
          })
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        // Aquí procesar la respuesta del servidor según lo necesites
        
      } catch (error) {
        console.error('ERROR ERROR ERROR: ', error);
      }
    },
    logout() {
      // Implementa la lógica para cerrar sesión, si es necesario
    },
    goToHome() {
      this.$router.push('/');
    }
  }
}
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1rem;
  background-color: #333;
  color: #fff;
}

.logo {
  display: flex;
  align-items: center;
}

.logo img {
  height: 40px;
  margin-right: 10px;
  cursor: pointer;
}

.nav ul {
  list-style: none;
  display: flex;
}

.nav li {
  margin-left: 1rem;
}

.button {
  font-size: 1.2rem;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  text-decoration: none;
  transition: background-color 0.3s ease;
}

.primary {
  background-color: #ffd700;
  color: #333;
}

.secondary {
  background-color: #333;
  color: #ffd700;
}

.button:hover {
  background-color: #fff;
  color: #333;
}
</style>
