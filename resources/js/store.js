import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
   state: {
       apiURL: 'http://localhost/api',
       serverPath: 'http://localhost',
   },
   mutations: {},
   actions: {}
});
