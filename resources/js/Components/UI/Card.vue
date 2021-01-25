<template>
  <div class="w-full my-5">
    <div class="bg-white shadow-md">
      <div class="">
        <slot name="img"></slot>
      </div>
      <div class="px-4 py-4 md:px-8">
        <div class="label text-xs mb-3">
          <slot name="heading"></slot>
        </div>
        <h1 class="font-bold text-2xl">
          <slot name="title"></slot>
        </h1>
        <p class="py-4">
          <slot></slot>
        </p>
      </div>
      <div class="px-4 py-4 md:px-8 border-t">
        <div class="flex flex-wrap">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {

}
</script>
