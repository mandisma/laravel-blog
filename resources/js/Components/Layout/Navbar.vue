<template>
  <div class="md:flex md:flex-shrink-0">
    <div class="bg-gray-900 md:flex-shrink-0 md:w-56 px-6 py-4 flex items-center justify-between md:justify-center">
      <inertia-link :href="route('admin.dashboard')">
        <jet-application-mark class="block h-9 w-auto" />
      </inertia-link>
      <button
        class="hover:text-blue-500 hover:border-white focus:outline-none navbar-burger md:hidden"
        @click="toggleSidebar()"
      >
        <svg
          class="h-5 w-5"
          :style="{ fill: 'black' }"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <title>Menu</title>
          <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
        </svg>
      </button>
    </div>
    <div class="bg-gray-800 border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-between items-center">
      <!-- search bar -->
      <div class="relative text-gray-600">
        <input
          type="search"
          name="search"
          placeholder="Search products..."
          class="bg-white h-10 w-full xl:w-64 px-5 rounded-lg border text-sm focus:outline-none"
        >
        <button
          type="submit"
          class="absolute right-0 top-0 mt-3 mr-4"
        >
          <svg
            id="Capa_1"
            class="h-4 w-4 fill-current"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            version="1.1"
            x="0px"
            y="0px"
            viewBox="0 0 56.966 56.966"
            style="enable-background: new 0 0 56.966 56.966"
            xml:space="preserve"
            width="512px"
            height="512px"
          >
            <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
          </svg>
        </button>
      </div>
      <!-- right navbar -->
      <!-- Settings Dropdown -->
      <div class="hidden sm:flex sm:items-center sm:ml-6">
        <div class="ml-3 relative">
          <jet-dropdown
            align="right"
            width="48"
          >
            <template #trigger>
              <button
                v-if="$page.props.jetstream.managesProfilePhotos"
                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out"
              >
                <img
                  class="h-8 w-8 rounded-full object-cover"
                  :src="$page.props.user.profile_photo_url"
                  :alt="$page.props.user.name"
                >
              </button>

              <button
                v-else
                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out"
              >
                <div>{{ $page.props.user.name }}</div>

                <div class="ml-1">
                  <svg
                    class="fill-current h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
              </button>
            </template>

            <template #content>
              <!-- Front -->
              <div class="block px-4 py-2 text-xs text-gray-400">
                Front
              </div>

              <jet-dropdown-link :href="route('home')">
                Home
              </jet-dropdown-link>

              <div class="border-t border-gray-100" />

              <!-- Account Management -->
              <div class="block px-4 py-2 text-xs text-gray-400">
                Manage Account
              </div>

              <jet-dropdown-link :href="route('profile.show')">
                Profile
              </jet-dropdown-link>

              <jet-dropdown-link
                v-if="$page.props.jetstream.hasApiFeatures"
                :href="route('api-tokens.index')"
              >
                API Tokens
              </jet-dropdown-link>

              <div class="border-t border-gray-100" />

              <!-- Team Management -->
              <template v-if="$page.props.jetstream.hasTeamFeatures">
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Manage Team
                </div>

                <!-- Team Settings -->
                <jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">
                  Team Settings
                </jet-dropdown-link>

                <jet-dropdown-link
                  v-if="$page.props.jetstream.canCreateTeams"
                  :href="route('teams.create')"
                >
                  Create New Team
                </jet-dropdown-link>

                <div class="border-t border-gray-100" />

                <!-- Team Switcher -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  Switch Teams
                </div>

                <template v-for="team in $page.props.user.all_teams">
                  <form
                    :key="team.id"
                    @submit.prevent="switchToTeam(team)"
                  >
                    <jet-dropdown-link as="button">
                      <div class="flex items-center">
                        <svg
                          v-if="team.id == $page.props.user.current_team_id"
                          class="mr-2 h-5 w-5 text-green-400"
                          fill="none"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>{{ team.name }}</div>
                      </div>
                    </jet-dropdown-link>
                  </form>
                </template>

                <div class="border-t border-gray-100" />
              </template>

              <!-- Authentication -->
              <form @submit.prevent="logout">
                <jet-dropdown-link as="button">
                  Logout
                </jet-dropdown-link>
              </form>
            </template>
          </jet-dropdown>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'
import JetApplicationMark from '@/Jetstream/ApplicationMark'

export default {
  name: 'Navbar',
  components: {
    JetDropdown,
    JetDropdownLink,
    JetApplicationMark
  },
  props: {
    sideBarOpen: {
      type: Boolean,
      required: true
    }
  },
  methods: {
    toggleSidebar () {
      this.$emit('update:sideBarOpen', !this.sideBarOpen)
    },
    switchToTeam (team) {
      this.$inertia.put(
        route('current-team.update'),
        {
          team_id: team.id
        },
        {
          preserveState: false
        }
      )
    },
    logout () {
      axios.post(route('logout').url()).then((response) => {
        window.location = '/'
      })
    }
  }
}
</script>
