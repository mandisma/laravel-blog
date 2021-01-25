<template>
  <div
    id="main-body"
    class="md:flex md:flex-col bg-cool-gray-100"
  >
    <div class="md:h-screen md:flex md:flex-col">
      <navbar :side-bar-open.sync="sideBarOpen" />

      <div class="md:flex md:flex-grow md:overflow-hidden">
        <sidebar
          :key="url()"
          :side-bar-open.sync="sideBarOpen"
        />

        <div
          id="main-content"
          scroll-region
          class="md:flex-1 md:overflow-y-auto p-6"
          :class="sideBarOpen ? 'overlay' : ''"
        >
          <main>
            <flash-messages />
            <slot />
          </main>

          <!-- <base-footer></base-footer> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from '@/Components/Layout/Sidebar'
import Navbar from '@/Components/Layout/Navbar'
// import BaseFooter from '@/Components/Layout/Footer'
import FlashMessages from '@/Components/Layout/FlashMessages'

export default {
  name: 'Dashboard',
  components: {
    Sidebar,
    Navbar,
    // BaseFooter,
    FlashMessages
  },
  data () {
    return {
      sideBarOpen: true
    }
  },
  methods: {
    url () {
      return location.pathname.substr(1)
    }
  }
}
</script>
