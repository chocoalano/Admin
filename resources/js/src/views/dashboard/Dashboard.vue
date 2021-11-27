<template>
  <div>
    <v-row>
      <v-col cols="12" md="4">
        <dashboard-congratulation-john></dashboard-congratulation-john>
      </v-col>
      <v-col cols="12" md="8">
        <dashboard-statistics-card></dashboard-statistics-card>
      </v-col>
    </v-row>

    <v-row>
      <v-col>
        <dashboard-agent></dashboard-agent>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import DashboardCongratulationJohn from './DashboardCongratulationJohn.vue'
import DashboardStatisticsCard from './DashboardStatisticsCard.vue'
import DashboardAgent from './DashboardAgent.vue'

export default {
  components: {
    DashboardCongratulationJohn,
    DashboardStatisticsCard,
    DashboardAgent
  },
}
</script>
