<template>
  <body>
    <Header />
  <div class="formContainer">
    

    <div class="container">
      <form @submit.prevent="fetchLogin">
        <label for="email">Email</label>
        <input type="text" id="email" v-model="email" placeholder="example@gmail.com">

        <label for="password">Contraseña</label>
        <input type="password" id="password" v-model="password" placeholder="contraseña actual">

        <router-link to="/register" class="router-link">¿No tens compte? Regístrat</router-link>

        <button type="submit">Login</button>
      </form>
    </div>
  </div>
  <Footer />
      
</body>
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
body{
  margin: 0;
  padding: 0;
  height: 100%;
}

.formContainer{
  height: 58vh;
}

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
