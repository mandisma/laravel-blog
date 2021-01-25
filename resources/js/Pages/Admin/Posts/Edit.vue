<template>
  <div>
    <page-header>
      <inertia-link
        class="text-blue-400 hover:text-blue-600"
        :href="route('admin.posts.index')"
      >
        Posts
      </inertia-link>
      <span class="text-blue-400 font-medium">/</span> {{ form.title }}
    </page-header>
    <div class="flex">
      <div class="w-2/3 mr-4">
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
                v-if="post"
                class="mt-2"
              >
                <base-image
                  :src="post.data.thumbnail.url"
                  :srcset="post.data.thumbnail.srcset"
                  :width="post.data.thumbnail.width"
                  :height="post.data.thumbnail.height"
                  :loading="post.data.thumbnail.loading"
                  sizes="1px"
                  alt="Current Thumbnail Image"
                  customClass="rounded-full h-20 w-20 object-cover"
                ></base-image>
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
                v-if="post"
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
              class="text-red-600 hover:underline"
              type="button"
              @click="deletePost"
            >
              Delete Post
            </button>
            <button
              class="flex items-center btn-indigo ml-auto btn-blue"
              type="submit"
              :disabled="form.processing"
            >
              Save Post
            </button>
          </template>
        </x-form>
      </div>
      <div class="w-1/3">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg mb-4">
          <h3 class="border-b p-4 font-semibold">Status</h3>
          <div class="p-6 bg-white">
            <button class="btn-blue" @click="publish()" v-if="post.data.status !== 'published'">Publish</button>
            <button class="btn-blue" @click="view()" v-if="post.data.status === 'published'">View</button>
          </div>
        </div>
      </div>
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
import BaseImage from '@/Components/UI/BaseImage'

export default {
  components: {
    XForm,
    JetInput,
    JetInputError,
    JetLabel,
    JetSecondaryButton,
    ckeditor: CKEditor.component,
    PageHeader,
    BaseImage
  },
  layout: AdminLayout,
  props: {
    errors: Object,
    post: Object
  },
  data () {
    return {
      form: this.$inertia.form(
        {
          _method: 'PUT',
          title: this.post ? this.post.data.title : null,
          content: this.post ? this.post.data.content : null,
          thumbnail: null
        },
        {
          bag: 'editPost',
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
      this.form.post(route('admin.posts.update', this.post.data.id))
    },
    deletePost () {
      this.$inertia.delete(route('admin.posts.destroy', this.post.data.id))
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
        .delete(route('admin.posts_thumbnail.destroy', this.post.data.id), {
          preserveScroll: true
        })
        .then(() => {
          this.thumbnailPreview = null
        })
    },
    publish () {
      console.log('a', route('admin.posts.publish'))
      console.log('b', route('admin.posts.publish', this.post.data.id))
      this.$inertia.post(route('admin.posts.publish', this.post.data.id))
    },
    view () {
      this.$inertia.visit(route('posts.show', this.post.data.slug))
    }
  }
}
</script>
