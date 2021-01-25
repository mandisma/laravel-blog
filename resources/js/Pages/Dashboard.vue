<template>
  <div>
    <page-header>Dashboard</page-header>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <welcome />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'
import Welcome from '@/Jetstream/Welcome'
import PageHeader from '@/Components/UI/PageHeader'

export default {
  components: {
    Welcome,
    PageHeader
  },
  layout: AdminLayout
}
</script>
