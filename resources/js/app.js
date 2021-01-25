import Vue from 'vue'

import { InertiaApp, plugin } from '@inertiajs/inertia-vue'
import { InertiaForm } from 'laravel-jetstream'
import PortalVue from 'portal-vue'
import { InertiaProgress } from '@inertiajs/progress'
import Notifications from 'vue-notification'

require('./bootstrap')

Vue.mixin({ methods: { route } })
Vue.use(plugin)
Vue.use(InertiaForm)
Vue.use(PortalVue)
Vue.use(require('vue-moment'))
Vue.use(Notifications)

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 250,

  // The color of the progress bar.
  color: '#29d',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: false
})

const app = document.getElementById('app')

new Vue({
  render: (h) => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: (name) => require(`./Pages/${name}`).default
    }
  })
}).$mount(app)
