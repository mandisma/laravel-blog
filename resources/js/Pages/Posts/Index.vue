<template>
  <div>
    <div class="">
      <div class="w-2/3">
        <article
          v-for="post in posts.data"
          :key="post.id"
          class=""
        >
          <card>
            <template #img>
              <inertia-link :href="route('posts.show', post.slug)">
                <base-image
                  :src="post.thumbnail.url"
                  :srcset="post.thumbnail.srcset"
                  :alt="post.thumbnail.name"
                  :width="post.thumbnail.width"
                  :height="post.thumbnail.height"
                  :loading="post.thumbnail.loading"
                  customClass="object-cover h-64 w-full"
                  sizes="1px"
                ></base-image>
              </inertia-link>
            </template>
            <template
              #heading
              class=""
            >
              <span class="text-purple-400 font-bold">Catgory</span>
              <span class="text-gray-400 font-bold">/</span>
              <span class="text-gray-400 font-bold">{{ post.created_at | moment('from', 'now') }}</span>
            </template>
            <template #title>
              <inertia-link
                :href="route('posts.show', post.slug)"
                class="text-purple-400 hover:text-purple-600 transition"
              >{{ post.title }}</inertia-link>
            </template>
            <p class="mb-6 leading-7">
              {{post.excerpt}}
            </p>
            <inertia-link
              :href="route('posts.show', post.slug)"
              class="text-purple-300 text-sm hover:text-purple-500 transition"
            >Read more...</inertia-link>
            <template #footer>
              <div class="post__author flex items-center">
                <img
                  class="block rounded-full w-12 mr-4"
                  :src="post.author.profile_photo_url"
                >
                <div class="author__content leading-none">
                  <h4 class="font-sans text-black font-bold mb-2">by <a
                      class="text-purple-400 hover:text-purple-600 transition"
                      href="/@author_slug"
                    >{{post.author.name}}</a></h4>
                </div>
              </div>
            </template>
          </card>
        </article>
        <pagination :meta="posts.meta" />
      </div>
    </div>
  </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Pagination from '@/Components/UI/Pagination'
import BaseImage from '@/Components/UI/BaseImage'
import Card from '@/Components/UI/Card'

export default {
  layout: AppLayout,
  components: {
    Pagination,
    BaseImage,
    Card
  },
  props: {
    posts: Object
  }
}
</script>
