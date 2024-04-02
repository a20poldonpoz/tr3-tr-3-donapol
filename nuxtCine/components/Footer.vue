<template>
  <footer class="footer">
    <div class="container">
      <div class="footer-links">
        <div class="footer-column">
          <h3>Enlaces</h3>
          <ul>
            <li><a href="#">Inici</a></li>
            <li><a href="#">Cartelera</a></li>
            <li><router-link to="/nosotros">Sobre nosotros</router-link></li>
            <li><a href="#">Contacto</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h3>Redes Sociales</h3>
          <ul>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Instagram</a></li>
          </ul>
        </div>
        <div class="footer-column">
          <h3>Contacto</h3>
          <p>Dirección: Av. Ejemplo 123, Ciudad Ejemplo</p>
          <p>Teléfono: 123-456-789</p>
          <p>Email: info@cineejemplo.com</p>
        </div>
      </div>
    </div>
  </footer>
</template>

<style>
.footer {
  background-color: #222;
  color: #fff;
  padding: 50px 0;
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
  margin-bottom: 10px;
}

.footer-column ul {
  list-style-type: none;
  padding: 0;
}

.footer-column ul li {
  margin-bottom: 5px;
}

.footer-column ul li a {
  color: #fff;
  text-decoration: none;
}

.footer-column p {
  margin: 5px 0;
}
</style>
