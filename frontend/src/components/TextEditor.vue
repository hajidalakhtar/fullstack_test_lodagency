<template>
  <div>
    <bubble-menu :editor="editor" :tippy-options="{ duration: 100 }" v-if="editor">
      <template v-for="level in [1, 2, 3]">
        <button @click="editor.chain().focus().toggleHeading({ level }).run()"
                :class="{
          'btn': true,
          'btn-outline-dark': !editor.isActive('heading', { level }),
          'btn-dark': editor.isActive('heading', { level })
        }"
                style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
        >
          Heading {{ level }}
        </button>
      </template>
      <button @click="editor.chain().focus().toggleBold().run()"
              :class="{
        'btn': true,
        'btn-outline-dark': !editor.isActive('bold'),
        'btn-dark': editor.isActive('bold')
      }"
              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
      >
        bold
      </button>

      <button @click="editor.chain().focus().toggleItalic().run()"
              :class="{
        'btn': true,
        'btn-outline-dark': !editor.isActive('italic'),
        'btn-dark': editor.isActive('italic')
      }"
              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
      >
        italic
      </button>

      <button @click="editor.chain().focus().toggleStrike().run()"
              :class="{
        'btn': true,
        'btn-outline-dark': !editor.isActive('strike'),
        'btn-dark': editor.isActive('strike')
      }"
              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
      >
        strike
      </button>


    </bubble-menu>
    <editor-content :editor="editor"/>

  </div>
</template>

<script>
import {EditorContent, Editor, BubbleMenu} from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import {Placeholder} from "@tiptap/extension-placeholder";

export default {
  components: {
    EditorContent,
    BubbleMenu
  },

  props: {
    modelValue: {
      type: String,
      default: '',
    },
  },

  emits: ['update:modelValue'],

  data() {
    return {
      editor: null,
    }
  },

  watch: {
    modelValue(value) {
      // HTML
      const isSame = this.editor.getHTML() === value

      // JSON
      // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

      if (isSame) {
        return
      }

      this.editor.commands.setContent(value, false)
    },
  },

  mounted() {
    this.editor = new Editor({
      extensions: [
        StarterKit,
        Placeholder.configure({
          placeholder: 'Mulaikah menulis artikel mu disini',
        })
      ],
      content: this.modelValue,
      onUpdate: () => {
        this.$emit('update:modelValue', this.editor.getHTML())
      },
    })
  },

  beforeUnmount() {
    this.editor.destroy()
  }
}
</script>

<style lang="scss">

.tiptap {
  > * + * {
    margin-top: 0.75em;
  }
}

.tiptap p.is-editor-empty:first-child::before {
  content: attr(data-placeholder);
  float: left;
  color: #adb5bd;
  pointer-events: none;
  height: 0;
}

.tiptap {
  > * + * {
    margin-top: 0.75em;
  }

  ul,
  ol {
    padding: 0 1rem;
  }
}

</style>