// ~/store/index.js
import { defineStore } from 'pinia';

export const useStore = defineStore({
  id: 'main',
  state: () => ({
    user_id: null,
    email: null,
    isAuthenticated: false 
  }),
  actions: {
    login(id, email) {
      this.user_id = id;
      this.email = email;
      this.isAuthenticated = true;
    },

    logout() {
      this.user_id = null;
      this.email = null;
      this.isAuthenticated = false;
    },

    getAuthenticationStatus() {
      return this.isAuthenticated;
    }
  }
});
