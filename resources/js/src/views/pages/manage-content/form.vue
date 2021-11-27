<template>
  <v-container>
    <v-row>
      <v-col cols="12" sm="12" md="12">
        <tiptap-vuetify v-model="formItem.content" :extensions="extensions" />
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-select v-model="formItem.page_display" :items="states" menu-props="auto" label="Display Content"></v-select>
      </v-col>
      <v-col cols="12" sm="6" md="4">
        <v-switch v-model="formItem.status" :label="`Status: ${formItem.status.toString()}`"></v-switch>
      </v-col>
    </v-row>
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
  data: () => ({
    // declare extensions you want to use
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
    // starting editor's content
    states: ['home', 'term', 'contact', 'gallery'],
  }),
  computed: {
    ...mapState('content', {
      formItem: state => state.formItem,
    }),
    formItem: {
      get: function () {
        return this.$store.state.content.formItem
      },
      set: function (value) {
        this.$store.commit('content/SET_FORM', value)
      },
    },
  },
}
</script>