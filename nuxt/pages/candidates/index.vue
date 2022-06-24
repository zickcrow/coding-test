<template>
  <main>
    <div class="container mx-auto pt-8">
      <div class="mt-6 mb-24">
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
          <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden">
              <table
                class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 relative"
              >
                <thead class="bg-gray-100 dark:bg-gray-700">
                  <tr>
                    <th
                      v-for="(header, index) in headers"
                      :key="index"
                      scope="col"
                      class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                    >
                      {{ header }}
                    </th>
                  </tr>
                </thead>
                <tbody
                  class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700 relative"
                >
                  <tr v-if="$fetchState.pending">
                    <td colspan="10">
                      <span class="loading"></span>
                    </td>
                  </tr>
                  <tr v-else-if="$fetchState.error">
                    <td colspan="10">Error while fetching candidates 🤬</td>
                  </tr>
                  <template v-else>
                    <tr
                      v-for="candidate in candidates"
                      :key="candidate.id"
                      class="hover:bg-gray-100 dark:hover:bg-gray-700 relative"
                    >
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ candidate.id }}
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ candidate.name }}
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"
                      >
                        {{ candidate.education.label }}
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ candidate.birthday }}
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ candidate.experience }} years
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ candidate.lastPosition.label }}
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ candidate.appliedPosition.label }}
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 dark:text-white whitespace-nowrap"
                      >
                        <div class="flex space-x-2">
                          <div
                            v-for="(skill, idx) in candidate.skills"
                            :key="idx"
                            class="text-xs px-3 bg-gray-200 text-gray-800 rounded-full"
                            style="padding-top: 0.1em; padding-bottom: 0.1rem"
                          >
                            {{ skill }}
                          </div>
                        </div>
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ candidate.email }}
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        {{ candidate.phone }}
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                      >
                        <a :href="candidate.resume" download>link</a>
                      </td>
                      <td
                        class="py-4 px-6 text-sm font-medium text-right sticky top-0 right-0"
                      >
                        <div class="flex flex-col items-start justify-center">
                          <NuxtLink
                            v-show="canRead"
                            :to="`/candidates/${candidate.id}/show`"
                            class="text-green-600 dark:text-green-500 hover:underline py-1"
                            >Show</NuxtLink
                          >
                          <NuxtLink
                            v-show="canEdit"
                            :to="`/candidates/${candidate.id}/edit`"
                            class="text-blue-600 dark:text-blue-500 hover:underline py-1"
                            >Edit</NuxtLink
                          >
                          <a
                            v-show="canDelete"
                            class="text-red-600 dark:text-blue-500 hover:underline py-1 cursor-pointer"
                            @click="deleteCandidate(candidate.id)"
                          >
                            Delete
                          </a>
                        </div>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>
<script>
export default {
  middleware: 'auth',
  async fetch() {
    this.candidates = await this.$axios
      .$get('/api/v1/candidates')
      .then((response) => response.data)
  },
  data() {
    return {
      candidates: [],
      headers: [
        'ID',
        'Name',
        'Education',
        'Birthday',
        'Experience',
        'Last Position',
        'Applied Position',
        'Skills',
        'Email',
        'Phone',
        'Resume',
        'Action',
      ],
      scopes: [],
    }
  },
  computed: {
    canRead() {
      return (
        'read-candidate' in
        JSON.parse(window.localStorage.getItem('loggedInUser')).scopes
      )
    },
    canEdit() {
      return (
        'edit-candidate' in
        JSON.parse(window.localStorage.getItem('loggedInUser')).scopes
      )
    },
    canDelete() {
      return (
        'delete-candidate' in
        JSON.parse(window.localStorage.getItem('loggedInUser')).scopes
      )
    },
  },
  activated() {
    this.$fetch()
    this.scopes = JSON.parse(window.localStorage.getItem('loggedInUser')).scopes
  },
  methods: {
    async deleteCandidate(id) {
      await this.$axios
        .$delete(`/api/v1/candidates/${id}`)
        .then(() => this.$fetch())
    },
  },
}
</script>
