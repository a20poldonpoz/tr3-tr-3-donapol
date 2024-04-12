<template>
  <div>
    <Header />
    <div class="loadingOverlay" v-if="loading">
      <img src="../public/img/carga.gif" alt="Cargando...">
    </div>
    <div class="pageContent" :class="{ 'loading': loading }">
      <div class="formContainer">
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
    </div>
    <Footer />
  </div>
</template>

<script>

export default {
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      tipusUsuari: null,
      user_id: null,
      ErrorPost: false,
    }
  },
  methods: {
    async fetchLogin() {
      try {
        this.loading = true;
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
        this.fetchId();

      } catch (error) {
        console.error('ERROR ERROR ERROR: ', error);
      } finally {
        this.loading = false; // Desactivar la carga después de recibir una respuesta
      }
    },
    async fetchId() {
      try {
        let response = await fetch(`http://tr3pol.daw.inspedralbes.cat/laravel/public/api/get-id?email=${encodeURIComponent(this.email)}`);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        let data = await response.json();

        this.user_id = data.user.id;
        this.tipusUsuari = data.user.tipus;

        if (this.user_id == null) {
          alert('ERROR FETCH USER');
          setTimeout(() => {
            this.ErrorPost = true;
          }, 2500);
          this.ErrorPost = false;
        }

        const userStore = useStore();
        userStore.guardar_info_usuari(data.user.name, this.email, this.user_id, this.tipusUsuari);

        this.$router.push('/cartelera');

      } catch (error) {
        console.error('ERROR FETCH USER: ', error);
      }
    }




  }
}
</script>


<style scoped>
body {
  margin: 0;
  padding: 0;
  height: 100%;
}

.formContainer {
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

/*Estils per que quan fa login, que no pugui fer res l'usuari*/
.loadingOverlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.loadingOverlay img {
  width: 100px;
}

.pageContent {
  opacity: 1;
  transition: opacity 0.3s;
}

.pageContent.loading {
  opacity: 0.5;
  pointer-events: none;
}
</style>
