<template>
  <admin-layout>
    <page-header>
      Team Settings
    </page-header>

    <div>
      <div class="max-w-7xl">
        <update-team-name-form
          :team="team"
          :permissions="permissions"
        />

        <team-member-manager
          class="mt-10 sm:mt-0"
          :team="team"
          :available-roles="availableRoles"
          :user-permissions="permissions"
        />

        <template v-if="permissions.canDeleteTeam && ! team.personal_team">
          <jet-section-border />

          <delete-team-form
            class="mt-10 sm:mt-0"
            :team="team"
          />
        </template>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import TeamMemberManager from './TeamMemberManager'
import DeleteTeamForm from './DeleteTeamForm'
import UpdateTeamNameForm from './UpdateTeamNameForm'
import PageHeader from '@/Components/UI/PageHeader'

export default {

  components: {
    AdminLayout,
    DeleteTeamForm,
    JetSectionBorder,
    TeamMemberManager,
    UpdateTeamNameForm,
    PageHeader
  },
  props: [
    'team',
    'availableRoles',
    'permissions'
  ]
}
</script>
