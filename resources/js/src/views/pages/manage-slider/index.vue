<template>
  <v-data-table
    :headers="headers"
    :items="desserts"
    :options.sync="options"
    :server-items-length="totalDesserts"
    :loading="loading"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar flat color="transparent">
        <v-toolbar-title>Data Operations</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-alert dense outlined type="error" v-if="errors.length > 0">
          {{ errors }} <strong>please</strong> be more careful in <strong>creating </strong> of slider
        </v-alert>
        <v-alert dense outlined type="success" v-model="alert">
          <strong>Success</strong> you have successfully on <strong>creating </strong> new slider
        </v-alert>
        <v-dialog v-model="dialog" width="500">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on"> New Item </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <form-slider></form-slider>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
              <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:[`item.img`]="{ item }">
      <v-img
        :src="baseUrl + '/storage/img/slider/' + item.img"
        lazy-src="https://picsum.photos/id/11/10/6"
        width="2%"
        class="rounded-xl"
      >
        <template v-slot:placeholder>
          <v-row class="fill-height ma-0" align="center" justify="center">
            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
          </v-row>
        </template>
      </v-img>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon small class="mr-2" @click="editItem(item.id)"> mdi-pencil </v-icon>
      <v-icon small @click="deleteItem(item.id)"> mdi-delete </v-icon>
    </template>
  </v-data-table>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import FormSlider from './form'
export default {
  data() {
    return {
      alert: false,
    }
  },
  components: { FormSlider },
  computed: {
    ...mapState(['baseUrl']),
    ...mapState('slider', {
      totalDesserts: state => state.totalDesserts,
      desserts: state => state.desserts,
      options: state => state.options,
      loading: state => state.loading,
      headers: state => state.headers,

      dialog: state => state.dialog,
      dialogDelete: state => state.dialogDelete,
      formIndex: state => state.formIndex,
      formItem: state => state.formItem.index,
    }),
    ...mapState(['errors']),
    errors: {
      get: function () {
        return this.$store.state.errors
      },
      set: function (value) {
        this.$store.commit('SET_ERRORS', value, { root: true })
      },
    },
    options: {
      get: function () {
        return this.$store.state.slider.options
      },
      set: function (value) {
        this.$store.commit('slider/SET_OPTIONS', value)
      },
    },
    loading: {
      get: function () {
        return this.$store.state.slider.loading
      },
      set: function (value) {
        this.$store.commit('slider/SET_LOADING', value)
      },
    },

    dialog: {
      get: function () {
        return this.$store.state.slider.dialog
      },
      set: function (value) {
        this.$store.commit('slider/SET_DIALOG', value)
      },
    },
    dialogDelete: {
      get: function () {
        return this.$store.state.slider.dialogDelete
      },
      set: function (value) {
        this.$store.commit('slider/SET_DIALOG_DELETE', value)
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
    formTitle() {
      return this.formIndex === -1 ? 'New Item' : 'Edit Item'
    },
  },
  watch: {
    options: {
      handler() {
        this.getDataFromApi()
      },
      deep: true,
    },
    formItem(e) {
      this.$store.commit('slider/SET_FORM_INDEXS', e)
    },
  },
  mounted() {
    this.getDataFromApi()
  },
  methods: {
    ...mapActions('slider', ['Index', 'Show', 'Update', 'Store', 'Delete']),
    ...mapActions('auth', ['logout']),
    getColor(status) {
      if (status) {
        return 'green'
      } else {
        console.log(status)
      }
    },
    getDataFromApi() {
      this.Index().then(e => {
        if (e != 200) {
          this.logout().then(() => {
            this.$router.push({ name: 'pages-login' })
          })
        }
      })
    },
    editItem(item) {
      this.$store.commit('slider/SET_FORM_INDEX', item)
      this.Show().then(res => {
        const form = {
          img: [],
          status: res.data.data.status,
        }
        this.$store.commit('slider/SET_FORM', form)
        this.$store.commit('slider/SET_SHOW_IMG', res.data.data.img)
        console.log(res.data.data.img)
      })
      this.dialog = true
    },

    deleteItem(item) {
      this.$store.commit('slider/SET_FORM_INDEX', item)
      this.dialogDelete = true
    },

    deleteItemConfirm() {
      this.Delete(this.formIndex).then(res => {
        if (res.status === 200) {
          this.closeDelete()
        }
      })
    },

    close() {
      this.$store.commit('slider/SET_FORM_INDEX', -1)
      this.$store.commit('slider/CLEAR_FORM')
      this.dialog = false
      this.alert = false
    },

    closeDelete() {
      this.$store.commit('slider/SET_FORM_INDEX', -1)
      this.dialogDelete = false
    },

    save() {
      if (this.formIndex === -1) {
        this.Store().then(res => {
          if (res.status === 200) {
            this.alert = res.data.success
            this.close()
            setTimeout(() => {
              this.alert = false
            }, 3000)
          }
        })
      } else {
        this.Update().then(res => {
          if (res.status === 200) {
            this.alert = res.data.success
            setTimeout(() => {
              this.alert = false
            }, 3000)
            this.close()
          }
        })
      }
    },
  },
}
</script>