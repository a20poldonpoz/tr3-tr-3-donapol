<template>
  <header class="header">
    <div class="logo" @click="goToHome">
      <img src="../public/img/logo.PNG" alt="Logo" />
    </div>
    <nav class="nav">
      <ul>
        <li><nuxt-link to="/cartelera" class="button secondary">Cartelera</nuxt-link></li>
        <li><nuxt-link to="/reservas" class="button secondary">Les Meves Sessions</nuxt-link></li>
        <li><nuxt-link v-if="!loguejat" to="/login" class="button primary">Login/Registre</nuxt-link></li>
        <li><nuxt-link v-if="loguejat" to="/perfil" class="button primary">Perfil</nuxt-link></li>
        <li><nuxt-link v-if="loguejat && admin" to="/admin" class="button primary">Admin</nuxt-link></li>
        <li><nuxt-link v-if="loguejat" to="/" @click="logout" class="button primary">Logout</nuxt-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'Header',
  computed: {
    loguejat() {
      const userStore = useStore();
      return userStore.loguejat;
    },
    admin() {
      const userStore = useStore();
      return userStore.tipusUsuari;
    }
  },
  methods: {
    async logout() {
      const userStore = useStore();
      userStore.logout(); 
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
