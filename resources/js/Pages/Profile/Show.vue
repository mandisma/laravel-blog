<template>
  <admin-layout>
    <page-header>
      Profile
    </page-header>

    <div>
      <div class="max-w-7xl">
        <update-profile-information-form :user="$page.props.user" />

        <jet-section-border />

        <update-password-form class="mt-10 sm:mt-0" />

        <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
          <jet-section-border />

          <two-factor-authentication-form class="mt-10 sm:mt-0" />
        </div>

        <jet-section-border />

        <logout-other-browser-sessions-form
          :sessions="sessions"
          class="mt-10 sm:mt-0"
        />

        <jet-section-border />

        <delete-user-form class="mt-10 sm:mt-0" />
      </div>
    </div>
  </admin-layout>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'
import JetSectionBorder from '@/Jetstream/SectionBorder'
import DeleteUserForm from './DeleteUserForm'
import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
import UpdatePasswordForm from './UpdatePasswordForm'
import UpdateProfileInformationForm from './UpdateProfileInformationForm'
import PageHeader from '@/Components/UI/PageHeader'

export default {

  components: {
    AdminLayout,
    DeleteUserForm,
    JetSectionBorder,
    LogoutOtherBrowserSessionsForm,
    TwoFactorAuthenticationForm,
    UpdatePasswordForm,
    UpdateProfileInformationForm,
    PageHeader
  },
  props: ['sessions']
}
</script>
