import Vue from 'vue'
import Vuex from 'vuex'

import auth from './modules/auth.js'
import dashboard from './modules/dashboard.js'
import user from './modules/user.js'
import account from './modules/account.js'
import content from './modules/content.js'
import gallery from './modules/gallery.js'
import medsos from './modules/medsos.js'
import page from './modules/page.js'
import seo from './modules/seo.js'
import service from './modules/service.js'
import serviceRegist from './modules/serviceRegist.js'
import slider from './modules/slider.js'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    token: localStorage.getItem('token'),
    errors: [],
    baseUrl: process.env.NODE_ENV ==
            'production' ?
            window.location.protocol + '//' + window.location.hostname :
            window.location.protocol + '//' + window.location.hostname + ':8000',
  },
  getters: {
    isAuth: state => {
      return state.token != "null" && state.token != null
    }
  },
  mutations: {
    SET_TOKEN(state, payload) {
      state.token = payload
    },
    SET_ERRORS(state, payload) {
      state.errors = payload
    },
    CLEAR_ERRORS(state) {
      state.errors = []
    }
  },
  modules: {
    auth,
    dashboard,
    user,
    account,
    content,
    gallery,
    medsos,
    page,
    seo,
    service,
    serviceRegist,
    slider,
  },
})
