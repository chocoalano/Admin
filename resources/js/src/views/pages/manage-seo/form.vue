<template>
  <v-container>
    <v-row>
      <v-col>
        <v-text-field v-model="formItem.name" label="Name"></v-text-field>
      </v-col>
      <v-col>
        <v-text-field v-model="formItem.title" label="Title"></v-text-field>
      </v-col>
      <v-col>
        <v-select v-model="formItem.page" :items="states" menu-props="auto" label="Page"></v-select>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-textarea v-model="formItem.hid" outlined name="input-7-4" label="Content"></v-textarea>
      </v-col>
      <v-col>
        <v-textarea v-model="formItem.content" outlined name="input-7-4" label="Content"></v-textarea>
      </v-col>
    </v-row>
    <v-alert dense outlined type="success" v-model="alert" class="mt-3 mb-3">
      <strong>Success</strong> you have successfully on <strong>creating </strong> new seo
    </v-alert>
  </v-container>
</template>
<script>
import { mapState } from 'vuex'
export default {
  data() {
    return {
      alert: false,
      states: ['home', 'gallery', 'contact', 'term'],
    }
  },
  computed: {
    ...mapState(['baseUrl']),
    ...mapState('seo', {
      formItem: state => state.formItem,
      formIndex: state => state.formIndex,
    }),
    formItem: {
      get: function () {
        return this.$store.state.seo.formItem
      },
      set: function (value) {
        this.$store.commit('seo/SET_FORM', value)
      },
    },
    formIndex: {
      get: function () {
        return this.$store.state.seo.formIndex
      },
      set: function (value) {
        this.$store.commit('seo/SET_FORM_INDEX', value)
      },
    },
  },
}
</script>