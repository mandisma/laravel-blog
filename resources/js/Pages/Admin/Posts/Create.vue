<template>
  <div>
    <page-header>
      <inertia-link
        class="text-blue-400 hover:text-blue-600"
        :href="route('admin.posts.index')"
      >
        Posts
      </inertia-link>
      <span class="text-blue-400 font-medium">/</span> Create
    </page-header>
    <div class="w-2/3">
      <x-form @submitted="submit">
        <template #form>
          <div class="col-span-6 sm:col-span-4">
            <jet-label
              for="title"
              value="Title"
            />
            <jet-input
              id="title"
              v-model="form.title"
              type="text"
              class="mt-1 block w-full"
              autocomplete="title"
            />
            <jet-input-error
              :message="form.error('title')"
              class="mt-2"
            />
          </div>
          <div class="col-span-6 sm:col-span-4">
            <jet-label
              for="content"
              value="Content"
            />
            <ckeditor
              v-model="form.content"
              :editor="editor"
            />
            <jet-input-error
              :message="form.error('content')"
              class="mt-2"
            />
          </div>
          <div class="col-span-6 sm:col-span-4">
            <!-- Thumbnail Image File Input -->
            <input
              ref="thumbnail"
              type="file"
              class="hidden"
              @change="updateThumbnailPreview"
            >

            <jet-label
              for="thumbnail"
              value="Thumbnail"
            />

            <!-- Current Thumbnail Image -->
            <div
              v-show="!thumbnailPreview"
              v-if="post && thumbnail_url"
              class="mt-2"
            >
              <img
                :src="thumbnail_url"
                alt="Current Thumbnail Image"
                class="rounded-full h-20 w-20 object-cover"
              >
            </div>

            <!-- New Thumbnail Image Preview -->
            <div
              v-show="thumbnailPreview"
              class="mt-2"
            >
              <span
                class="block rounded-full w-20 h-20"
                :style="
                  'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
                    thumbnailPreview +
                    '\');'
                "
              />
            </div>

            <jet-secondary-button
              class="mt-2 mr-2"
              type="button"
              @click.native.prevent="selectNewThumbnail"
            >
              Select A New Thumbnail
            </jet-secondary-button>

            <jet-secondary-button
              v-if="post && post.thumbnail"
              type="button"
              class="mt-2"
              @click.native.prevent="deleteThumbnail"
            >
              Remove Thumbnail
            </jet-secondary-button>

            <jet-input-error
              :message="form.error('thumbnail')"
              class="mt-2"
            />
          </div>
        </template>
        <template #actions>
          <button
            class="flex items-center btn-indigo ml-auto btn-blue"
            type="submit"
            :disabled="form.processing"
          >
            Create Post
          </button>
        </template>
      </x-form>
    </div>
  </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'
import XForm from '@/Components/UI/BaseForm'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import CKEditor from '@ckeditor/ckeditor5-vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import PageHeader from '@/Components/UI/PageHeader'

export default {
  components: {
    XForm,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    ckeditor: CKEditor.component,
    PageHeader
  },
  layout: AdminLayout,
  props: {
    errors: Object,
    post: Object,
    thumbnail_url: String
  },
  data () {
    return {
      form: this.$inertia.form(
        {
          _method: 'POST',
          title: this.post ? this.post.title : null,
          content: this.post ? this.post.content : null,
          thumbnail: null
        },
        {
          bag: 'createPost',
          resetOnSuccess: false
        }
      ),
      editor: ClassicEditor,
      thumbnailPreview: null
    }
  },
  methods: {
    submit () {
      if (this.$refs.thumbnail) {
        this.form.thumbnail = this.$refs.thumbnail.files[0]
      }
      this.form._method = 'POST'
      this.form.post(route('admin.posts.store'))
    },
    deletePost () {
      this.$inertia.delete(route('admin.posts.destroy', this.post.id))
    },

    selectNewThumbnail () {
      this.$refs.thumbnail.click()
    },

    updateThumbnailPreview () {
      const reader = new FileReader()

      reader.onload = (e) => {
        this.thumbnailPreview = e.target.result
      }

      reader.readAsDataURL(this.$refs.thumbnail.files[0])
    },

    deleteThumbnail () {
      this.$inertia
        .delete(route('admin.posts_thumbnail.destroy', this.post.id), {
          preserveScroll: true
        })
        .then(() => {
          this.thumbnailPreview = null
        })
    }
  }
}
</script>
