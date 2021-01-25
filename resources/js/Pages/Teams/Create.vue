<template>
  <admin-layout>
    <page-header>
      Create Team
    </page-header>

    <div>
      <div class="max-w-7xl">
        <create-team-form />
      </div>
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'
import CreateTeamForm from './CreateTeamForm'
import PageHeader from '@/Components/UI/PageHeader'

export default {

  components: {
    AdminLayout,
    CreateTeamForm,
    PageHeader
  },
  props: ['team']
}
</script>
