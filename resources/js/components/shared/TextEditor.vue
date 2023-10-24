<template>
  <div
    :id="`html-editor-${id}`"
    @keyup="contentsUpdated"
    style="height: 15em"
    v-html="contents ? contents : ''"
  ></div>
</template>

<script>
  import Quill from 'quill';

  export default {
    props: {
      contents: {
        required: false,

        default: null,
      },
    },
    data() {
      return {
        editor: null,
        id: Math.floor(Math.random() * 100),
      };
    },
    mounted() {
      this.setupEditor();
    },
    methods: {
      setupEditor() {
        const options = {
          debug: 'warn',
          modules: {
            // toolbar: '#toolbar',
          },
          placeholder: '',
          readOnly: false,
          theme: 'snow',
        };
        this.editor = new Quill(`#html-editor-${this.id}`, options);
      },
      contentsUpdated() {
        var QuillDeltaToHtmlConverter = require('quill-delta-to-html').QuillDeltaToHtmlConverter;

        var cfg = {};
        let delta = this.editor.getContents();
        var converter = new QuillDeltaToHtmlConverter(delta.ops, cfg);
        var html = converter.convert();

        this.$emit('contentsUpdated', html);
      },
    },
  };
</script>
