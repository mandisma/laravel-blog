<template>
  <div>
    <img
      v-bind="$attrs"
      :class="customClass"
      @error="fallbackImage"
      ref="myImg"
    />
  </div>
</template>

<script>
export default {
  inheritAttrs: false,

  props: {
    src: {
      type: String,
      required: true
    },
    customClass: String
  },

  mounted () {
    const img = this.$refs.myImg
    window.requestAnimationFrame(function () {
      const size = img.getBoundingClientRect().width
      if (!size) {
        return
      }
      img.onload = null
      img.sizes = Math.ceil(size / window.innerWidth * 100) + 'vw'
    })
  },

  methods: {
    fallbackImage (event) {
      // const img = event.target
      console.log('uh uh')
    }
  }
}
</script>
