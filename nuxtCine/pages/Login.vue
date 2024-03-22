<template>
  <div>
    <Header />

    <div class="container">
      <form @submit.prevent="fetchLogin">
        <label for="email">Email</label>
        <input type="text" id="email" v-model="email" placeholder="example@gmail.com">

        <label for="password">Contraseña</label>
        <input type="password" id="password" v-model="password" placeholder="contraseña actual">

        <router-link to="/register" class="router-link">¿No tienes cuenta? Regístrate</router-link>

        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</template>

<script>
import {useStore} from '../stores/index.js'
export default {
  data() {
    return {
      email: '',
      password: ''
    }
  },
  methods: {
    async fetchLogin() {
      try {
        const response = await fetch('http://tr3pol.daw.inspedralbes.cat/laravel/public/api/login', {
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
        const store= useStore()
        store.correo="hol"
        this.$router.push('/cartelera');

      } catch (error) {
        console.error('ERROR ERROR ERROR: ', error);
      }
    }
  }
}
</script>

<style scoped>
.container {
  max-width: 400px;
  margin: 50px auto; 
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
}

form {
  display: flex;
  flex-direction: column;
}

label {
  margin-bottom: 5px;
  font-weight: bold; 
}

input[type="text"],
input[type="password"],
button {
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  transition: border-color 0.3s; 
}

input[type="text"]:focus,
input[type="password"]:focus {
  border-color: #007bff; 
}

button {
  background-color: #007bff;
  color: #fff;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s; 
}

button:hover {
  background-color: #0056b3; 
}

.router-link {
  text-decoration: none;
  color: #007bff;
  transition: color 0.3s; 
}

.router-link:hover {
  text-decoration: underline;
  color: #0056b3; 
}

</style>
