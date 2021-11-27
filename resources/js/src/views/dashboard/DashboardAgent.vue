<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="desserts"
      :options.sync="options"
      :server-items-length="totalDesserts"
      :loading="loading"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat color="transparent">
          <v-toolbar-title>Data Pengunjung</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn class="ma-2" outlined @click.stop="dialog = true"> Truncate Data </v-btn>
        </v-toolbar>
      </template>
    </v-data-table>
    <v-dialog v-model="dialog" max-width="290">
      <v-card>
        <v-card-title class="text-h5"> Mohon lebih diperhatikan lagi! </v-card-title>

        <v-card-text>
          Fungsi truncate akan menghapus seluruh data pengunjung yang ada tanpa myisakan data pengunjung sedikitpun.
          Apakah anda yakin akan tetap melakukanya ?
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="green darken-1" text @click="dialog = false"> Tidak lakukan </v-btn>

          <v-btn color="green darken-1" text @click="truncate()"> Lakukan </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import { mapState, mapActions } from 'vuex'
export default {
  data() {
    return {
      dialog: false,
    }
  },
  computed: {
    ...mapState('dashboard', {
      totalDesserts: state => state.totalDesserts,
      desserts: state => state.desserts,
      options: state => state.options,
      loading: state => state.loading,
      headers: state => state.headers,
    }),
    options: {
      get: function () {
        return this.$store.state.dashboard.options
      },
      set: function (value) {
        this.$store.commit('dashboard/SET_OPTIONS', value)
      },
    },
    loading: {
      get: function () {
        return this.$store.state.dashboard.loading
      },
      set: function (value) {
        this.$store.commit('dashboard/SET_LOADING', value)
      },
    },
  },
  watch: {
    options: {
      handler() {
        this.getDataFromApi()
      },
      deep: true,
    },
  },
  mounted() {
    this.getDataFromApi()
  },
  methods: {
    ...mapActions('dashboard', ['Index','Truncate']),
    ...mapActions('auth', ['logout']),
    getDataFromApi() {
      this.Index().then(e => {
        if (e != 200) {
          this.logout().then(() => {
            this.$router.push({ name: 'pages-login' })
          })
        }
      })
    },
    truncate(){
      this.Truncate().then(e => {
        this.dialog= false
      })
    }
  },
}
</script>