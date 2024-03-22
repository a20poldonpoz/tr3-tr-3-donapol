<template>
    <div>
    <Header />

    <div class="container">
      <form @submit.prevent="fetchLogin">

        <label for="name">Nom</label>
        <input type="text" id="name" v-model="name">

        <label for="email">Email</label>
        <input type="text" id="email" v-model="email">

        <label for="password">Contraseña</label>
        <input type="password" id="password" v-model="password">

        <router-link to="/register" class="router-link">¿No tens comte? Registrat</router-link>

        <button type="submit">Registra't</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      password: ''
      
    }
  },
  methods: {
    async fetchLogin() {
      try {
        const response = await fetch('http://tr3pol.daw.inspedralbes.cat/laravel/public/api/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            name: this.name,
            email: this.email,
            password: this.password
          })
        });
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.$router.push('/cartelera');

      } catch (error) {
        console.error('ERROR ERROR ERROR: ', error);
      }
    }
  }
}
</script>

<style lang="scss" scoped>

</style>