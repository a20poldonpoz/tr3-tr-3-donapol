<template>
  <body>

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

        <button type="submit">Registra't</button>
      </form>
    </div>
  </div>
  <Footer />
</body>
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
        const response = await fetch('http://localhost:8000/api/register', {
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

<style scoped>
body{
  margin: 0;
  padding: 0;
  height: 100%;
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
