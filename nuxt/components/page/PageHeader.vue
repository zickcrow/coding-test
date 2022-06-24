<template>
  <header class="text-gray-700 body-font">
    <div
      class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center"
    >
      <NuxtLink
        to="/"
        class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          stroke="currentColor"
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          class="w-10 h-10 text-white p-2 bg-blue-500 rounded-full"
          viewBox="0 0 24 24"
        >
          <path
            d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"
          ></path>
        </svg>
        <span class="ml-3 text-xl">coding-test</span>
      </NuxtLink>
      <nav
        class="md:ml-auto md:mr-auto flex flex-wrap items-center text-base justify-center"
      >
        <NuxtLink
          v-if="$auth.loggedIn"
          to="/candidates"
          class="mr-5 hover:text-gray-900"
        >
          Candidates
        </NuxtLink>
      </nav>

      <div v-if="$auth.loggedIn" class="ml-3 relative">
        <div>
          <button
            id="user-menu"
            class="relative z-10 flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-blue-300 transition duration-150 ease-in-out"
            aria-label="User menu"
            aria-haspopup="true"
            @click="accountDropdownIsOpen = !accountDropdownIsOpen"
          >
            <img
              class="h-8 w-8 rounded-full"
              src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
              alt=""
            />
          </button>
          <button
            v-if="accountDropdownIsOpen"
            tabindex="-1"
            class="fixed w-full h-full inset-0 cursor-default"
            @click="accountDropdownIsOpen = false"
          ></button>
        </div>
        <div
          v-if="accountDropdownIsOpen"
          class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg"
        >
          <div
            class="py-1 rounded-md bg-white shadow-xs"
            role="menu"
            aria-orientation="vertical"
            aria-labelledby="user-menu"
            @click="accountDropdownIsOpen = false"
          >
            <NuxtLink
              to="/profile"
              class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
              role="menuitem"
            >
              Profile
            </NuxtLink>
            <button
              class="block duration-150 ease-in-out focus:bg-gray-100 focus:outline-none hover:bg-gray-100 leading-5 px-4 py-2 text-gray-700 text-left text-sm transition w-full"
              @click="logout"
            >
              Sign out
            </button>
          </div>
        </div>
      </div>
      <div v-else>
        <NuxtLink
          to="/login"
          class="inline-flex items-center bg-gray-200 border-0 py-1 px-3 focus:outline-none hover:bg-gray-300 rounded text-base mt-4 md:mt-0"
        >
          Login
          <svg
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            class="w-4 h-4 ml-1"
            viewBox="0 0 24 24"
          >
            <path d="M5 12h14M12 5l7 7-7 7"></path>
          </svg>
        </NuxtLink>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  data() {
    return {
      accountDropdownIsOpen: false,
    }
  },
  methods: {
    async logout() {
      this.error = null

      await this.$auth
        .logout('laravelPassportPassword')
        .then(() => {
          window.localStorage.removeItem('loggedInUser')
          this.$router.push('/')
        })
        .catch((e) => (this.error = e.response.data))
    },
  },
}
</script>
