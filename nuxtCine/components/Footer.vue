<template>
  <footer class="footer">
    <div class="container">
      <div class="footer-links">
        <div class="footer-column">
          <h3>Enlaces</h3>
          <ul>
            <li><router-link to="/">Inici</router-link></li>
            <li><router-link to="/cartelera">Cartelera</router-link></li>
            <li><router-link to="/nosotros">Sobre nosaltres</router-link></li>
            <li><router-link to="/Register">Registra't</router-link></li>
          </ul>
        </div>
        <div class="footer-column">
          <h3>Xarxes Socials</h3>
          <ul>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Instagram</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h3>Contacte</h3>
          <p>Av.Olesa de Bonesvalls 27, Vallirana</p>
          <p>644887418</p>
          <p>info@cineliaco.com</p>
        </div>
      </div>
    </div>
  </footer>
</template>

<style>
.footer {
  background-color: #222;
  color: #fff;
  padding: 30px 0;
}

.container {
  width: 80%;
  margin: 0 auto;
}

.footer-links {
  display: flex;
  justify-content: space-between;
}

.footer-column {
  flex: 1;
}

.footer-column h3 {
  font-size: 18px;
}

.footer-column ul {
  list-style-type: none;
  padding: 0;
}



.footer-column ul li a {
  color: #fff;
  text-decoration: none;
}

.footer-column p {
  margin: 5px 0;
}
</style>
