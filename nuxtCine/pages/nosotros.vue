<template>
  <Header />
  <div class="about-us">
    <h1>Sobre Nosaltres</h1>
    <div class="about-content">
      <p>Benvingut al nostre cinema</p>
      <p>Som un destí per als amants del cinema a la ciutat, oferint una experiència cinematogràfica única i emocionant per a tots els cinèfils.</p>
    </div>

    <div class="mission">
      <h2>La Nostra Missió</h2>
      <p>La nostra missió en el cinema és proporcionar a la nostra comunitat una experiència cinematogràfica excepcional, oferint una àmplia selecció de pel·lícules de qualitat, còmodes instal·lacions i un servei al client de primera classe.</p>
    </div>

    <div class="team">
      <h2>El Nostre Equip</h2>
      <p>Darrere de cada projecció i esdeveniment especial en el nostre cinema hi ha el nostre equip apassionat i dedicat. Des dels nostres concessionaris fins al nostre personal de projecció, tots treballem junts per garantir que cada visita al nostre cinema sigui memorable i satisfactòria.</p>
    </div>

    <div class="facilities">
      <h2>Les Nostres Instal·lacions</h2>
      <p>El nostre cinema compta amb instal·lacions modernes i còmodes, incloent sales de projecció equipades amb tecnologia de vanguardia, seients reclinables i una àmplia varietat de snacks i begudes al nostre concessionari.</p>
    </div>

    <div class="contact">
      <h2>Contacta'ns</h2>
      <p>Esperem veure't aviat al nostre cinema! Si tens alguna pregunta o comentari, no dubtis a posar-te en contacte amb nosaltres.</p>
      <p>Correu electrònic: a20poldonpoz@inspedralbes.cat</p>
      <p>Telèfon: 644887418</p>
    </div>
  </div>
  <Footer />
</template>

<style scoped>
.about-us {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  text-align: center;
}

.about-content, .mission, .team, .facilities, .contact {
  margin-bottom: 40px;
}

h1 {
  font-size: 2.5em;
  color: #333;
}

h2 {
  font-size: 1.8em;
  color: #333;
}

p {
  font-size: 1.1em;
  color: #666;
}

@media (max-width: 768px) {
  h1 {
    font-size: 2em;
  }

  h2 {
    font-size: 1.5em;
  }

  p {
    font-size: 1em;
  }
}
</style>
