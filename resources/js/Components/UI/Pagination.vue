<template>
  <div class="mt-6 -mb-1 flex flex-wrap" v-if="meta.last_page !== 1">
    <template v-for="(link, key) in meta.links">
      <div
        v-if="link.url === null"
        :key="key"
        class="mr-1 mb-1 px-4 py-3 text-sm border rounded text-gray-400"
      >
        {{ link.label }}
      </div>
      <inertia-link
        v-else
        :key="key"
        class="mr-1 mb-1 px-4 py-3 text-sm border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500"
        :class="{ 'bg-white': link.active}"
        :href="link.url"
      >
        {{ link.label }}
      </inertia-link>
    </template>
  </div>
</template>

<script>
export default {
  props: {
    meta: Object
  }
}
</script>
