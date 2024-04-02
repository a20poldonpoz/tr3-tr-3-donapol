// ~/store/index.js
import {defineStore } from 'pinia';

export const useStore = defineStore({
  id: 'main',
  state: () => ({
    user_id: null,
    email: null
  }),
  actions: {
    guardarInfoUser(id, email) {
        this.user_id = id,
        this.email = email
    },

    obtenerInfoUser() {
        return this.user_id
    },

    obteneremail() {
      return this.email
  },


    guardarEmail(){
      this.email = email
    }
  },
});
