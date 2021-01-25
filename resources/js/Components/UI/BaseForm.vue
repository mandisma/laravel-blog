<template>
  <div>
    <form @submit.prevent="$emit('submitted')">
      <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6">
          <div class="grid grid-cols-6 gap-6">
            <slot name="form" />
          </div>
        </div>

        <div
          v-if="hasActions"
          class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center"
        >
          <slot name="actions" />
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  computed: {
    hasActions () {
      return !!this.$slots.actions
    }
  }
}
</script>
