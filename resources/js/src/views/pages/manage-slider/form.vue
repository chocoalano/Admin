<template>
  <v-container>
    <v-row>
      <v-col>
        <v-file-input accept="image/*" v-model="formItem.img" label="Files Image Slider" />
      </v-col>
      <v-col>
        <v-switch v-model="formItem.status" :label="`Status: ${formItem.status.toString()}`"></v-switch>
      </v-col>
    </v-row>
    {{ showImg }}
    <v-row v-if="showImg != ''" class="d-flex justify-center">
      <v-card class="rounded-xl">
        <v-card-text>
          <v-img
            :src="baseUrl + '/storage/img/slider/' + showImg"
            lazy-src="https://picsum.photos/id/11/10/6"
            width="100%"
            class="rounded-xl"
          >
            <template v-slot:placeholder>
              <v-row class="fill-height ma-0" align="center" justify="center">
                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
              </v-row>
            </template>
          </v-img>
        </v-card-text>
      </v-card>
    </v-row>
  </v-container>
</template>
<script>
import { mapState } from 'vuex'
export default {
  computed: {
    ...mapState(['baseUrl']),
    ...mapState('slider', {
      formItem: state => state.formItem,
      formIndex: state => state.formIndex,
      showImg: state => state.showImg,
    }),
    showImg: {
      get: function () {
        return this.$store.state.slider.showImg
      },
      set: function (value) {
        this.$store.commit('slider/SET_SHOW_IMG', value)
      },
    },
    formItem: {
      get: function () {
        return this.$store.state.slider.formItem
      },
      set: function (value) {
        this.$store.commit('slider/SET_FORM', value)
      },
    },
    formIndex: {
      get: function () {
        return this.$store.state.slider.formIndex
      },
      set: function (value) {
        this.$store.commit('slider/SET_FORM_INDEX', value)
      },
    },
  },
}
</script>