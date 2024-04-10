  // ~/store/index.js
  import { defineStore } from 'pinia';

  export const useStore = defineStore({
    id: 'main',
    state: () => ({
      user_id: null,
      email: null,
      loguejat: false,
      username: "",
    }),
    actions: {
      guardar_info_usuari(username, email, id) {
        this.username = username;
        this.email = email;
        this.user_id = id;
         this.loguejat = true;
      },


      logout() {
        this.user_id = null;
        this.email = null;
        this.loguejat = false;
        this.username = "";
      },

      returnLoguejat() {
        return this.loguejat;
      },

    }
  });
