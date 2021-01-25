<template>
  <div>
    <notifications />
  </div>
</template>

<script>
export default {
  watch: {
    '$page.props.props.flash': {
      handler () {
        if (this.$page.props.flash.success) {
          this.$notify({
            title: this.$page.props.flash.success,
            type: 'success',
            position: 'top center'
          })
        }
        if (this.$page.props.flash.error) {
          this.$notify({
            title: this.$page.props.flash.error,
            type: 'error'
          })
        }
      },
      deep: true
    }
  }
}
</script>
