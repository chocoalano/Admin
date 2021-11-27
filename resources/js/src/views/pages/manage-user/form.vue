<template>
  <v-container>
    <v-row>
      <v-col>
        <v-text-field
          label="Nama..."
          outlined
          dense
          prepend-inner-icon="mdi-account-circle"
          v-model="formItem.name"
        ></v-text-field>
      </v-col>
      <v-col>
        <v-text-field v-model="formItem.email" label="E-mail" dense outlined></v-text-field>
      </v-col>
      <v-col>
        <v-text-field
          v-model="formItem.password"
          :type="isCurrentPasswordVisible ? 'text' : 'password'"
          :append-icon="isCurrentPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
          label="Password"
          outlined
          dense
          @click:append="isCurrentPasswordVisible = !isCurrentPasswordVisible"
        ></v-text-field>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { ref } from '@vue/composition-api'
import { mdiEyeOffOutline, mdiEyeOutline } from '@mdi/js'
import { mapState } from 'vuex'
export default {
  setup() {
    const isCurrentPasswordVisible = ref(false)

    return {
      isCurrentPasswordVisible,
      icons: {
        mdiEyeOffOutline,
        mdiEyeOutline,
      },
    }
  },
  data() {
    return {
      alert: false,
      activePicker: null,
      menu: false,
    }
  },
  computed: {
    ...mapState('user', {
      formItem: state => state.formItem,
      formIndex: state => state.formIndex,
    }),
    formItem: {
      get: function () {
        return this.$store.state.user.formItem
      },
      set: function (value) {
        this.$store.commit('user/SET_FORM', value)
      },
    },
    formIndex: {
      get: function () {
        return this.$store.state.user.formIndex
      },
      set: function (value) {
        this.$store.commit('user/SET_FORM_INDEX', value)
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