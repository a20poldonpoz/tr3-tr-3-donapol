  // ~/store/index.js
  import { defineStore } from 'pinia';

  export const useStore = defineStore({
    id: 'main',
    state: () => ({
      user_id: null,
      email: null,
      loguejat: false,
      username: "",
      tipusUsuari: "",
    }),
    actions: {
      guardar_info_usuari(username, email, id, tipusUsuari) {
        this.username = username;
        this.email = email;
        this.user_id = id;
        this.loguejat = true;
        this.tipusUsuari = tipusUsuari;
      },

      returnTipus() {
        return this.tipusUsuari;
      }, 

      logout() {
        this.user_id = null;
        this.email = null;
        this.loguejat = false;
        this.tipusUsuari = "";
        this.username = "";
      },

      returnLoguejat() {
        return this.loguejat;
      },

    }
  });
