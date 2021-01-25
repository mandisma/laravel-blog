<template>
  <!-- give the sidebar z-50 class so its higher than the navbar if you want to see the logo -->
  <!-- you will need to add a little "X" button next to the logo in order to close it though -->
  <div
    id="main-nav"
    class="hidden md:block bg-gray-800 flex-shrink-0 w-56 py-6 overflow-y-auto"
    :class="sideBarOpen ? '' : 'hidden'"
  >
    <div class="mb-4 px-4">
      <!--<p class="pl-4 text-sm font-semibold mb-1">MAIN</p>-->
      <nav-link
        :href="route('admin.dashboard')"
        :active="route().current('admin.dashboard')"
      >
        <template #svg-path>
          <path
            d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"
          />
        </template>
        Dashboard
      </nav-link>
      <nav-link
        :href="route('admin.posts.index')"
        :active="route().current('admin.posts.index')"
      >
        <template #svg-path>
          <path
            d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156 M5.872,17.019h-2.89v-3.117h2.89V17.019zM9.587,17.019h-2.89V7.1h2.89V17.019z M13.303,17.019h-2.89v-6.651h2.89V17.019z M17.019,17.019h-2.891V2.982h2.891V17.019z"
          />
        </template>
        Posts
      </nav-link>
    </div>
  </div>
</template>

<script>
import NavLink from '@/Components/UI/NavLink'

export default {
  name: 'Sidebar',
  components: {
    NavLink
  },
  props: {
    sideBarOpen: {
      type: Boolean,
      required: true
    }
  }
}
</script>
