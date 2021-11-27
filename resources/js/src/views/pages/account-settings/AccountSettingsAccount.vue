<template>
  <v-card flat class="pa-3 mt-2">
    <v-card-text>
      <v-form class="multi-col-validation mt-6">
        <v-row>
          <v-col md="6" cols="12">
            <v-text-field v-model="form.name" label="Name" dense outlined></v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field v-model="form.email" label="E-mail" dense outlined></v-text-field>
          </v-col>

          <v-col cols="12">
            <v-btn color="primary" class="me-3 mt-4" @click="submit()"> Save changes </v-btn>
            <v-btn color="secondary" outlined class="mt-4" type="reset" @click.prevent="resetForm"> Cancel </v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card-text>
    <v-card-text v-if="alert">
      <v-alert dense text type="success">
        Success, <strong>Akun</strong> Anda <strong>Berhasil</strong> Diperbaharui
      </v-alert>
    </v-card-text>
  </v-card>
</template>
<script>
import { mapActions, mapState } from 'vuex'
export default {
  data() {
    return {
      alert: false,
    }
  },
  computed: {
    ...mapState('account', {
      form: state => state.formAccountUpdate,
    }),
  },
  created() {
    this.getUser()
  },
  methods: {
    ...mapActions('account', ['UpdateAccount', 'getAccount']),
    submit() {
      this.UpdateAccount().then(res => {
        if (res.status === 200) {
          this.alert = true
          setTimeout(() => {
            this.alert = false
          }, 3000)
        }
      })
    },
    getUser() {
      this.getAccount().then(res => {
        const forms = {
          name: res.data.data.name,
          email: res.data.data.email,
        }
        this.$store.commit('account/SET_FORM_ACCOUNT', forms)
      })
    },
  },
}
</script>
