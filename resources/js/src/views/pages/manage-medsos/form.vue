<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-text-field v-model="formItem.icon" label="Icon"></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-text-field v-model="formItem.link" label="Link"></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-switch v-model="formItem.status" :label="`Status: ${formItem.status.toString()}`"></v-switch>
      </v-col>
    </v-row>
    <v-alert dense outlined type="success" v-model="alert" class="mt-3 mb-3">
      <strong>Success</strong> you have successfully on <strong>creating </strong> new Medsos
    </v-alert>
  </v-container>
</template>
<script>
import { mapState } from 'vuex'
export default {
  data() {
    return {
      alert: false,
    }
  },
  computed: {
    ...mapState(['baseUrl']),
    ...mapState('medsos', {
      formItem: state => state.formItem,
      formIndex: state => state.formIndex,
    }),
    formItem: {
      get: function () {
        return this.$store.state.medsos.formItem
      },
      set: function (value) {
        this.$store.commit('medsos/SET_FORM', value)
      },
    },
    formIndex: {
      get: function () {
        return this.$store.state.medsos.formIndex
      },
      set: function (value) {
        this.$store.commit('medsos/SET_FORM_INDEX', value)
      },
    },
  },
}
</script>