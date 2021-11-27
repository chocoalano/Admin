<template>
  <v-card>
    <v-card-title class="align-start">
      <span class="font-weight-semibold">Informasi Pengunjung Situs Anda Bulan Ini.</span>
    </v-card-title>

    <v-card-text>
      <v-row>
        <v-col
          v-for="data in statisticsData"
          :key="data.title"
          cols="6"
          md="3"
          class="d-flex align-center"
        >
          <v-avatar
            size="44"
            :color="resolveStatisticsIconVariation (data.title).color"
            rounded
            class="elevation-1"
          >
            <v-icon
              dark
              color="white"
              size="30"
            >
              {{ resolveStatisticsIconVariation (data.title).icon }}
            </v-icon>
          </v-avatar>
          <div class="ms-3">
            <p class="text-xs mb-0">
              {{ data.title }}
            </p>
            <h3 class="text-xl font-weight-semibold">
              {{ data.total }}
            </h3>
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mdiAccountOutline, mdiMapMarkerDistance, mdiTrendingUp, mdiDotsVertical, mdiFlag } from '@mdi/js'
import { mapState, mapActions } from 'vuex'
export default {
  data() {
    return {
      statisticsData:[],
      icons: {
        mdiDotsVertical,
        mdiTrendingUp,
        mdiAccountOutline,
        mdiFlag,
        mdiMapMarkerDistance,
      },
    }
  },
  mounted() {
    this.getDataFromApi()
  },
  methods: {
    ...mapActions('dashboard', ['InfoPengunjung']),
    resolveStatisticsIconVariation(data){
      if (data === 'Diakses') return { icon: mdiTrendingUp, color: 'primary' }
      if (data === 'User') return { icon: mdiAccountOutline, color: 'success' }
      if (data === 'Negara') return { icon: mdiFlag, color: 'warning' }
      if (data === 'Wilayah') return { icon: mdiMapMarkerDistance, color: 'info' }
      return { icon: mdiAccountOutline, color: 'success' }
    },
    getDataFromApi() {
      this.InfoPengunjung().then(e => {
        this.statisticsData=e.data
      })
    },
  },
}
</script>
