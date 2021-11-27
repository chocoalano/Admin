<template>
  <v-container>
    <v-row>
      <v-col>
        <tiptap-vuetify v-model="formItem.text" :extensions="extensions" label="Text Content"/>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-select v-model="formItem.option" :items="states" menu-props="auto" label="Options"></v-select>
      </v-col>
      <v-col>
        <v-switch v-model="formItem.state" :label="`Status: ${formItem.state.toString()}`"></v-switch>
      </v-col>
    </v-row>
    <v-alert dense outlined type="success" v-model="alert" class="mt-3 mb-3">
      <strong>Success</strong> you have successfully on <strong>creating </strong> new page
    </v-alert>
  </v-container>
</template>
<script>
import { mapState } from 'vuex'
import {
  TiptapVuetify,
  Heading,
  Bold,
  Italic,
  Strike,
  Underline,
  Code,
  Paragraph,
  BulletList,
  OrderedList,
  ListItem,
  Link,
  Blockquote,
  HardBreak,
  HorizontalRule,
  History,
} from 'tiptap-vuetify'
export default {
  components: { TiptapVuetify },
  data() {
    return {
      extensions: [
        History,
        Blockquote,
        Link,
        Underline,
        Strike,
        Italic,
        ListItem,
        BulletList,
        OrderedList,
        [
          Heading,
          {
            options: {
              levels: [1, 2, 3],
            },
          },
        ],
        Bold,
        Code,
        HorizontalRule,
        Paragraph,
        HardBreak,
      ],
      alert: false,
      states: ['sitename', 'footer', 'zargon'],
    }
  },
  computed: {
    ...mapState(['baseUrl']),
    ...mapState('page', {
      formItem: state => state.formItem,
      formIndex: state => state.formIndex,
    }),
    formItem: {
      get: function () {
        return this.$store.state.page.formItem
      },
      set: function (value) {
        this.$store.commit('page/SET_FORM', value)
      },
    },
    formIndex: {
      get: function () {
        return this.$store.state.page.formIndex
      },
      set: function (value) {
        this.$store.commit('page/SET_FORM_INDEX', value)
      },
    },
  },
}
</script>