<template>
  <inertia-link
    :href="href"
    :class="classes"
  >
    <svg
      class="h-6 w-6 fill-current mr-2"
      viewBox="0 0 20 20"
    >
      <slot name="svg-path" />
    </svg>
    <span class="font-medium text-gray-300"><slot /></span>
  </inertia-link>
</template>

<script>
export default {
  props: ['href', 'active'],

  computed: {
    classes () {
      return this.active
        ? 'w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-900 rounded-lg cursor-pointer bg-gray-900'
        : 'w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-900 rounded-lg cursor-pointer'
    }
  }
}
</script>
