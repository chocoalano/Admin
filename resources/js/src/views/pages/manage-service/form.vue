<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-file-input
          label="File Icons"
          v-model="formItem.icon"
        ></v-file-input>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-text-field v-model="formItem.title" label="Title"></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-switch v-model="formItem.status" :label="`Status: ${formItem.status.toString()}`"></v-switch>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { mapState } from 'vuex'
export default {
  computed: {
    ...mapState(['baseUrl']),
    ...mapState('service', {
      formItem: state => state.formItem,
      formIndex: state => state.formIndex,
    }),
    formItem: {
      get: function () {
        return this.$store.state.service.formItem
      },
      set: function (value) {
        this.$store.commit('service/SET_FORM', value)
      },
    },
    formIndex: {
      get: function () {
        return this.$store.state.service.formIndex
      },
      set: function (value) {
        this.$store.commit('service/SET_FORM_INDEX', value)
      },
    },
  },
}
</script>