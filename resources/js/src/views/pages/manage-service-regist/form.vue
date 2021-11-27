<template>
  <v-container>
    <v-row>
      <v-col>
        <v-text-field
          label="Nama..."
          outlined
          dense
          prepend-inner-icon="mdi-account-circle"
          v-model="formItem.nama"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-menu
          ref="menu"
          v-model="menu"
          :close-on-content-click="false"
          transition="scale-transition"
          offset-y
          min-width="auto"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="formItem.tanggal"
              label="Tanggal..."
              prepend-inner-icon="mdi-calendar"
              readonly
              outlined
              dense
              v-bind="attrs"
              v-on="on"
            ></v-text-field>
          </template>
          <v-date-picker
            v-model="formItem.tanggal"
            :active-picker.sync="activePicker"
            :max="new Date(Date.now() - new Date().getTimezoneOffset() * 60000).toISOString().substr(0, 10)"
            min="1950-01-01"
            @change="save"
          ></v-date-picker>
        </v-menu>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-textarea outlined v-model="formItem.alamat" label="Alamat"></v-textarea>
      </v-col>
      <v-col>
        <v-textarea outlined v-model="formItem.keluhan" label="Keluhan"></v-textarea>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { mapState } from 'vuex'
export default {
  data() {
    return {
      alert: false,
      activePicker: null,
      menu: false,
    }
  },
  computed: {
    ...mapState('serviceRegist', {
      formItem: state => state.formItem,
      formIndex: state => state.formIndex,
    }),
    formItem: {
      get: function () {
        return this.$store.state.serviceRegist.formItem
      },
      set: function (value) {
        this.$store.commit('serviceRegist/SET_FORM', value)
      },
    },
    formIndex: {
      get: function () {
        return this.$store.state.serviceRegist.formIndex
      },
      set: function (value) {
        this.$store.commit('serviceRegist/SET_FORM_INDEX', value)
      },
    },
  },
  watch: {
    menu(val) {
      val && setTimeout(() => (this.activePicker = 'YEAR'))
    },
  },
  methods: {
    save(date) {
      this.$refs.menu.save(date)
    },
  },
}
</script>