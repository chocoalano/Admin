<template>
  <v-navigation-drawer
    :value="isDrawerOpen"
    app
    floating
    width="260"
    class="app-navigation-menu"
    :right="$vuetify.rtl"
    @input="val => $emit('update:is-drawer-open', val)"
  >
    <!-- Navigation Header -->
    <div class="vertical-nav-header d-flex items-center ps-6 pe-5 pt-5 pb-2">
      <router-link to="/" class="d-flex align-center text-decoration-none">
        <v-slide-x-transition>
          <h2 class="app-title text--primary">Admin Panel</h2>
        </v-slide-x-transition>
      </router-link>
    </div>

    <!-- Navigation Items -->
    <v-list expand shaped class="vertical-nav-menu-items pr-5">
      <nav-menu-link title="Beranda" :to="{ name: 'dashboard' }" :icon="icons.mdiHomeOutline"></nav-menu-link>
      <nav-menu-section-title title="Kelola"></nav-menu-section-title>
      <nav-menu-group title="Konten Halaman" :icon="icons.mdiFileOutline">
        <!-- <nav-menu-link title="Login" :to="{ name: 'pages-login' }"></nav-menu-link>
        <nav-menu-link title="Register" :to="{ name: 'pages-register' }"></nav-menu-link>
        <nav-menu-link title="Error" :to="{ name: 'error-404' }"></nav-menu-link> -->
        <nav-menu-link title="Kelola Konten" :to="{ name: 'manage-content' }"></nav-menu-link>
        <nav-menu-link title="Kelola Galeri" :to="{ name: 'manage-gallery' }"></nav-menu-link>
      </nav-menu-group>
      <nav-menu-group title="Pengaturan" :icon="icons.mdiApplicationCog">
        <nav-menu-link title="Kelola User" :to="{ name: 'manage-user' }"></nav-menu-link>
        <nav-menu-link title="Kelola Medsos" :to="{ name: 'manage-medsos' }"></nav-menu-link>
        <nav-menu-link title="Kelola Halaman" :to="{ name: 'manage-page' }"></nav-menu-link>
        <nav-menu-link title="Kelola SEO" :to="{ name: 'manage-seo' }"></nav-menu-link>
        <nav-menu-link title="Kelola Servis" :to="{ name: 'manage-service' }"></nav-menu-link>
        <nav-menu-link title="Kelola Slider" :to="{ name: 'manage-slider' }"></nav-menu-link>
        <nav-menu-link title="Kelola Pelanggan" :to="{ name: 'manage-service-regist' }"></nav-menu-link>
      </nav-menu-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mdiHomeOutline, mdiFileOutline,mdiApplicationCog } from '@mdi/js'
import NavMenuSectionTitle from './components/NavMenuSectionTitle.vue'
import NavMenuGroup from './components/NavMenuGroup.vue'
import NavMenuLink from './components/NavMenuLink.vue'

export default {
  components: {
    NavMenuSectionTitle,
    NavMenuGroup,
    NavMenuLink,
  },
  props: {
    isDrawerOpen: {
      type: Boolean,
      default: null,
    },
  },
  setup() {
    return {
      icons: {
        mdiHomeOutline,
        mdiFileOutline,
        mdiApplicationCog
      },
    }
  },
}
</script>

<style lang="scss" scoped>
@import '@resources/sass/preset/mixins.scss';

.app-title {
  font-size: 1.25rem;
  font-weight: 700;
  font-stretch: normal;
  font-style: normal;
  line-height: normal;
  letter-spacing: 0.3px;
}

// ? Adjust this `translateX` value to keep logo in center when vertical nav menu is collapsed (Value depends on your logo)
.app-logo {
  transition: all 0.18s ease-in-out;
  .v-navigation-drawer--mini-variant & {
    transform: translateX(-4px);
  }
}

@include theme(app-navigation-menu) using ($material) {
  background-color: map-deep-get($material, 'background');
}

.app-navigation-menu {
  .v-list-item {
    &.vertical-nav-menu-link {
      ::v-deep .v-list-item__icon {
        .v-icon {
          transition: none !important;
        }
      }
    }
  }
}

// You can remove below style
// Upgrade Banner
.app-navigation-menu {
  .upgrade-banner {
    position: absolute;
    bottom: 13px;
    left: 50%;
    transform: translateX(-50%);
  }
}
</style>
