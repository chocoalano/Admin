<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-text-field v-model="formItem.group_name" label="Group Name"></v-text-field>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-select v-model="formItem.page_display" :items="states" menu-props="auto" label="Display Content"></v-select>
      </v-col>
      <v-col cols="12" sm="6" md="2">
        <v-switch v-model="formItem.status" :label="`Status: ${formItem.status.toString()}`"></v-switch>
      </v-col>
      <v-col cols="12" sm="6" md="2" v-if="formIndex != -1">
        <v-switch v-model="formItem.index" :label="`${formItem.index ? 'Unuploaded' : 'Uploaded'}`"></v-switch>
      </v-col>
    </v-row>
    <v-row v-if="!formItem.index">
      <v-file-input
        id="uploadedfiles"
        v-model="files"
        show-size
        counter
        multiple
        clearable
        label="File input"
        name="uploadedfiles"
        @change="inputChanged"
      >
        <template #selection="{ index, text }">
          <v-chip small label close color="primary" @click:close="deleteChip(index, text)">{{ text }}</v-chip>
        </template>
      </v-file-input>
      <v-btn depressed color="primary" @click="uploaded"> Upload </v-btn>
    </v-row>
    <v-alert dense outlined type="success" v-model="alert" class="mt-3 mb-3">
      <strong>Success</strong> you have successfully on <strong>creating </strong> new gallery
    </v-alert>
    <v-row v-if="formIndex != ''">
      <div v-for="n in photos" :key="n.id">
        <v-card class="mr-2 ml-2">
          <v-img max-width="150" max-height="70" :src="baseUrl + '/storage/img/' + n.photo"> </v-img>
        </v-card>
      </div>
    </v-row>
  </v-container>
</template>
<script>
import { mapState, mapActions } from 'vuex'
export default {
  data() {
    return {
      alert: false,
      states: ['home', 'term', 'contact', 'gallery'],
      formFile: {
        child: true,
        _method: 'patch',
        img: [],
      },
      files: [],
    }
  },
  computed: {
    ...mapState(['baseUrl']),
    ...mapState('gallery', {
      formItem: state => state.formItem,
      formIndex: state => state.formIndex,
      photos: state => state.photos,
    }),
    photos: {
      get: function () {
        return this.$store.state.gallery.photos
      },
      set: function (value) {
        this.$store.commit('gallery/SET_FORM_PHOTOS', value)
      },
    },
    formItem: {
      get: function () {
        return this.$store.state.gallery.formItem
      },
      set: function (value) {
        this.$store.commit('gallery/SET_FORM', value)
      },
    },
    formIndex: {
      get: function () {
        return this.$store.state.gallery.formIndex
      },
      set: function (value) {
        this.$store.commit('gallery/SET_FORM_INDEX', value)
      },
    },
  },
  methods: {
    ...mapActions('gallery', ['UpdateChild']),
    uploaded() {
      this.UpdateChild(this.formFile).then(e => {
        if (e.status === 200) {
          this.$store.commit('gallery/SET_FORM_PHOTOS',[])
          this.alert = true
          setTimeout(() => {
            this.alert = false
          }, 2000)
        }
      })
    },
    deleteChip(index) {
      this.files.splice(index, 1)
      this.img.splice(index, 1)
    },
    inputChanged() {
      this.formFile.img.push(this.files[0])
    },
  },
}
</script>