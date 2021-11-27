import '@/plugins/vue-composition-api'
import '@resources/sass/styles/styles.scss'
import { mapGetters,mapActions } from 'vuex'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'

Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  computed: {
    ...mapGetters(['isAuth'])
  },
  methods: {
    ...mapActions('auth', ['auth'])
  },
  created() {
    if (this.isAuth) {
      this.auth().then((res)=>{
        if(res === 401){
          router.push({ name: 'pages-login'})
        }
      })
    }else{
      router.push({ name: 'pages-login'})
    }
  },
  render: h => h(App),
}).$mount('#app')
