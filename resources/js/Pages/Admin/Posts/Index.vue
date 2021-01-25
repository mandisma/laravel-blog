<template>
  <div>
    <page-header>
      Posts
    </page-header>
    <div class="mb-6 flex justify-between items-center">
      <search-filter
        v-model="form.search"
        class="w-full max-w-md mr-4"
        @reset="reset"
      />
      <inertia-link
        class="bg-blue-500 hover:bg-blue-600 rounded px-6 py-3 text-white text-sm font-bold whitespace-no-wrap"
        :href="route('admin.posts.create')"
      >
        Create Post
      </inertia-link>
    </div>
    <div>
      <div class="shadow overflow-x-auto border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                ID
              </th>
              <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Title
              </th>
              <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Author
              </th>
              <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Created at
              </th>
              <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider text-right">
                Actions
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr
              v-for="post in posts.data"
              :key="post.id"
              class="hover:bg-gray-100"
            >
              <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                {{ post.id }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                {{ post.title }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                {{ post.author.name }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                {{ post.created_at | moment("DD/MM/YYYY H:mm:ss") }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                {{ post.status }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                <inertia-link
                  :href="route('admin.posts.edit', post.id)"
                  class="text-blue-600 hover:text-blue-900"
                >
                  Edit
                </inertia-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <pagination :meta="posts.meta" />
    </div>
  </div>
</template>

<script>
import AdminLayout from '@/Layouts/AdminLayout'
import Pagination from '@/Components/UI/Pagination'
import SearchFilter from '@/Components/UI/SearchFilter'
import PageHeader from '@/Components/UI/PageHeader'
import throttle from 'lodash/throttle'
import pickBy from 'lodash/pickBy'
import mapValues from 'lodash/mapValues'

export default {
  components: {
    Pagination,
    SearchFilter,
    PageHeader
  },
  layout: AdminLayout,
  props: {
    posts: Object,
    filters: Object
  },
  data () {
    return {
      form: {
        search: this.filters.search
      }
    }
  },
  watch: {
    form: {
      handler: throttle(function () {
        const query = pickBy(this.form)
        this.$inertia.replace(this.route('admin.posts.index', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true
    }
  },
  methods: {
    reset () {
      this.form = mapValues(this.form, () => null)
    }
  }
}
</script>
