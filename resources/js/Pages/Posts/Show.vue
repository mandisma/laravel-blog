<template>
  <div>
    <div class="">
      <div class="w-2/3">
        <card>
          <template #img>
            <base-image
              :src="post.data.thumbnail.url"
              :srcset="post.data.thumbnail.srcset"
              :alt="post.data.thumbnail.name"
              :width="post.data.thumbnail.width"
              :height="post.data.thumbnail.height"
              :loading="post.data.thumbnail.loading"
              customClass="object-cover h-64 w-full"
              sizes="1px"
            ></base-image>
          </template>
          <template #title>
            <p class="text-purple-400">
              {{ post.data.title }}
            </p>
          </template>
          <p class="text-gray-400">
            {{ post.data.created_at | moment('from', 'now') }}
          </p>
          <p
            v-html="post.data.content"
            class="py-4 leading-7"
          ></p>
        </card>
      </div>
    </div>
  </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import BaseImage from '@/Components/UI/BaseImage'
import Card from '@/Components/UI/Card'

export default {
  layout: AppLayout,
  components: {
    BaseImage,
    Card
  },
  props: {
    post: Object
  }
}
</script>
