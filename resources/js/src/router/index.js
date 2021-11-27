import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store/index'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    redirect: 'dashboard',
  },
  {
    path: '/pages/login',
    name: 'pages-login',
    component: () => import('@/views/pages/Login.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '/pages/register',
    name: 'pages-register',
    component: () => import('@/views/pages/Register.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '/error-404',
    name: 'error-404',
    component: () => import('@/views/Error.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '*',
    redirect: 'error-404',
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import('@/views/dashboard/Dashboard.vue'),
    meta: { requiresAuth: true, title: 'Beranda' }
  },
  {
    path: '/pages/account-settings',
    name: 'pages-account-settings',
    component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
    meta: { requiresAuth: true, title: 'Pengaturan Akun' }
  },
  {
    path: '/pages/content',
    name: 'manage-content',
    component: () => import('@/views/pages/manage-content/index.vue'),
    meta: { requiresAuth: true, title: 'Kelola Konten' }
  },
  {
    path: '/pages/gallery',
    name: 'manage-gallery',
    component: () => import('@/views/pages/manage-gallery/index.vue'),
    meta: { requiresAuth: true, title: 'Kelola Galeri' }
  },
  {
    path: '/pages/user',
    name: 'manage-user',
    component: () => import('@/views/pages/manage-user/index.vue'),
    meta: { requiresAuth: true, title: 'Kelola Data User' }
  },
  {
    path: '/pages/medsos',
    name: 'manage-medsos',
    component: () => import('@/views/pages/manage-medsos/index.vue'),
    meta: { requiresAuth: true, title: 'Kelola Media Sosial' }
  },
  {
    path: '/pages/page',
    name: 'manage-page',
    component: () => import('@/views/pages/manage-page/index.vue'),
    meta: { requiresAuth: true, title: 'Kelola Halaman' }
  },
  {
    path: '/pages/seo',
    name: 'manage-seo',
    component: () => import('@/views/pages/manage-seo/index.vue'),
    meta: { requiresAuth: true, title: 'Kelola SEO' }
  },
  {
    path: '/pages/service',
    name: 'manage-service',
    component: () => import('@/views/pages/manage-service/index.vue'),
    meta: { requiresAuth: true, title: 'Kelola Servis' }
  },
  {
    path: '/pages/slider',
    name: 'manage-slider',
    component: () => import('@/views/pages/manage-slider/index.vue'),
    meta: { requiresAuth: true, title: 'Kelola Slider' }
  },
  {
    path: '/pages/service-regist',
    name: 'manage-service-regist',
    component: () => import('@/views/pages/manage-service-regist/index.vue'),
    meta: { requiresAuth: true, title: 'Kelola Pelanggan' }
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

router.beforeEach((to, from, next) => {
  store.commit('CLEAR_ERRORS')
  if (to.matched.some(record => record.meta.requiresAuth)) {
    let auth = store.getters.isAuth
    if (!auth) {
      next({ name: 'pages-login' })
    } else {
      next()
    }
  } else {
    next()
  }
})

export default router
