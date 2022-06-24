<template>
  <main>
    <div class="container mx-auto pt-8">
      <div class="mt-6 mb-64">
        <div class="overflow-x-auto shadow-md sm:rounded-lg p-6">
          <h1 class="text-xl text-gray-600 pb-4">
            {{ currentParam }} Candidate
          </h1>
          <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden">
              <p v-if="$fetchState.pending">
                <span class="loading"></span>
              </p>
              <p v-else-if="$fetchState.error">
                Error while fetching candidate 🤬
              </p>
              <form v-else @submit.prevent="submitCandidate">
                <div class="grid grid-cols-2 gap-4">
                  <div class="mt-4">
                    <label
                      class="block text-gray-600 text-sm font-medium mb-2"
                      for="formName"
                      >Name</label
                    >
                    <input
                      id="formName"
                      v-model="candidate.name"
                      class="bg-white text-gray-700 border border-gray-300 rounded py-2 px-4 block w-full focus:border-blue-500 focus:outline-none focus:shadow-outline"
                      type="text"
                      :placeholder="candidate.name"
                      :disabled="isDisabled"
                    />
                  </div>

                  <div class="mt-4">
                    <div class="flex justify-between">
                      <label
                        class="block text-gray-600 text-sm font-medium mb-2"
                        for="formEducation"
                        >Education</label
                      >
                    </div>
                    <TSelect
                      id="formEducation"
                      :value="candidate.education.value"
                      :options="educations"
                      :disabled="isDisabled"
                      value-attribute="value"
                      text-attribute="label"
                      placeholder="Select an Education Institution"
                    />
                  </div>

                  <div class="mt-4">
                    <div class="flex justify-between">
                      <label
                        class="block text-gray-600 text-sm font-medium mb-2"
                        for="formBirthday"
                        >Birthday</label
                      >
                    </div>
                    <TDatepicker
                      id="formBirthday"
                      :value="candidate.birthday"
                      :placeholder="candidate.birthday"
                      :disabled="isDisabled"
                    />
                  </div>

                  <div class="mt-4">
                    <div class="flex justify-between">
                      <label
                        class="block text-gray-600 text-sm font-medium mb-2"
                        for="formExperience"
                        >Experience</label
                      >
                    </div>

                    <input
                      id="formExperience"
                      v-model="candidate.experience"
                      class="bg-white text-gray-700 border border-gray-300 rounded py-2 px-4 block w-full focus:border-blue-500 focus:outline-none focus:shadow-outline"
                      type="number"
                      :placeholder="candidate.experience"
                      :disabled="isDisabled"
                    />
                  </div>

                  <div class="mt-4">
                    <div class="flex justify-between">
                      <label
                        class="block text-gray-600 text-sm font-medium mb-2"
                        for="formLastPosition"
                        >Last Position</label
                      >
                    </div>
                    <TSelect
                      id="formLastPosition"
                      :value="candidate.lastPosition.value"
                      :options="positions"
                      :disabled="isDisabled"
                      value-attribute="value"
                      text-attribute="label"
                      placeholder="Select a Position"
                    />
                  </div>

                  <div class="mt-4">
                    <div class="flex justify-between">
                      <label
                        class="block text-gray-600 text-sm font-medium mb-2"
                        for="formAppliedPosition"
                        >Applied Position</label
                      >
                    </div>
                    <TSelect
                      id="formAppliedPosition"
                      :value="candidate.appliedPosition.value"
                      :options="positions"
                      :disabled="isDisabled"
                      value-attribute="value"
                      text-attribute="label"
                      placeholder="Select a Position"
                    />
                  </div>

                  <div class="mt-4">
                    <div class="flex justify-between">
                      <label
                        class="block text-gray-600 text-sm font-medium mb-2"
                        for="formSkills"
                        >Skill</label
                      >
                    </div>
                    <TRichSelect
                      id="formSkills"
                      :value="candidate.skills"
                      :close-on-select="false"
                      :options="skills"
                      multiple
                      placeholder="Select multiple skills"
                    ></TRichSelect>
                  </div>

                  <div class="mt-4">
                    <div class="flex justify-between">
                      <label
                        class="block text-gray-600 text-sm font-medium mb-2"
                        for="formEmail"
                        >Email</label
                      >
                    </div>

                    <input
                      id="formEmail"
                      v-model="candidate.email"
                      class="bg-white text-gray-700 border border-gray-300 rounded py-2 px-4 block w-full focus:border-blue-500 focus:outline-none focus:shadow-outline"
                      type="email"
                      :placeholder="candidate.email"
                      :disabled="isDisabled"
                    />
                  </div>

                  <div class="mt-4">
                    <div class="flex justify-between">
                      <label
                        class="block text-gray-600 text-sm font-medium mb-2"
                        for="formPhone"
                        >Phone</label
                      >
                    </div>

                    <input
                      id="formPhone"
                      v-model="candidate.phone"
                      class="bg-white text-gray-700 border border-gray-300 rounded py-2 px-4 block w-full focus:border-blue-500 focus:outline-none focus:shadow-outline"
                      type="text"
                      :placeholder="candidate.phone"
                      :disabled="isDisabled"
                    />
                  </div>

                  <div class="mt-4">
                    <div class="flex justify-between">
                      <label
                        class="block text-gray-600 text-sm font-medium mb-2"
                        for="formResume"
                        >Resume</label
                      >
                      <button
                        v-if="isResumeExist"
                        class="block text-gray-600 text-sm font-medium mb-2"
                        @click.prevent="removeFile"
                      >
                        remove
                      </button>
                    </div>
                    <div>
                      <iframe
                        v-if="isResumeExist"
                        :src="blob"
                        class="bg-white text-gray-700 border border-gray-300 rounded py-2 px-4 block w-full focus:border-blue-500 focus:outline-none focus:shadow-outline"
                      />
                      <input
                        v-else
                        id="formResume"
                        ref="file"
                        class="bg-white text-gray-700 border border-gray-300 rounded py-2 px-4 block w-full focus:border-blue-500 focus:outline-none focus:shadow-outline"
                        type="file"
                        :placeholder="candidate.resume"
                        :disabled="isDisabled"
                        @change="handleFileUpload"
                      />
                    </div>
                  </div>
                </div>

                <div class="mt-8 flex-none w-full">
                  <button
                    class="bg-blue-500 text-white font-bold py-2 px-4 w-full rounded hover:bg-blue-600 focus:outline-none focus:bg-blue-600"
                  >
                    Submit
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="mt-3 max-w-screen-lg">
          <t-alert v-if="error" variant="error">
            <svg
              aria-hidden="true"
              class="fill-current mr-2"
              height="12"
              width="12"
              viewBox="0 0 16 16"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M10.115 1.308l5.635 11.269A2.365 2.365 0 0 1 13.634 16H2.365A2.365 2.365 0 0 1 .25 12.577L5.884 1.308a2.365 2.365 0 0 1 4.231 0zM8 10.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM8 9c.552 0 1-.32 1-.714V4.714C9 4.32 8.552 4 8 4s-1 .32-1 .714v3.572C7 8.68 7.448 9 8 9z"
                fill-rule="evenodd"
              ></path>
            </svg>
            {{ error }}
          </t-alert>
        </div>
        <div class="mt-3 max-w-screen-lg">
          <t-alert v-if="success" variant="success">
            {{ success }}
          </t-alert>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import {
  TAlert,
  TSelect,
  TRichSelect,
  TDatepicker,
} from 'vue-tailwind/dist/components'

export default {
  middleware: 'auth',
  components: {
    TAlert,
    TSelect,
    TRichSelect,
    TDatepicker,
  },
  async fetch() {
    this.candidate = await this.$axios.$get(
      `/api/v1/candidates/${this.$route.params.id}`
    )
    this.educations = await this.$axios.$get(`/api/v1/institutions`)
    this.positions = await this.$axios
      .$get(`/api/v1/positions`)
      .then((response) => response.data)
    this.skills = await this.$axios
      .$get(`/api/v1/skills`)
      .then((response) => response.data)

    if (this.candidate.resume) {
      this.generateBlobFromUrl(this.candidate.resume)
    }
  },
  data() {
    return {
      positions: [],
      educations: [],
      skills: [],
      blob: null,
      candidate: {
        id: '',
        name: '',
        education: {},
        birthday: '',
        experience: '',
        lastPosition: {},
        appliedPosition: {},
        skills: [],
        email: '',
        phone: '',
        resume: '',
      },
      error: null,
      success: null,
    }
  },
  computed: {
    currentParam() {
      return `${this.$route.params.param
        .charAt(0)
        .toUpperCase()}${this.$route.params.param.substr(1).toLowerCase()}`
    },
    isDisabled() {
      return this.$route.params.param === 'show'
    },
    currentSkills() {
      return this.candidate.skills.map((skill) => skill.value)
    },
    isResumeExist() {
      const resume = this.candidate.resume

      if (resume === null) {
        return false
      }

      if (resume === '') {
        return false
      }

      return true
    },
  },
  activated() {
    this.$fetch()
  },
  methods: {
    async submitCandidate() {
      const formData = new FormData()
      formData.append('name', this.candidate.name)
      formData.append(
        'education_institution_id',
        this.candidate.education.value
      )
      formData.append('birthday', this.candidate.birthday)
      formData.append('experience', this.candidate.experience)
      formData.append('last_position_id', this.candidate.lastPosition.value)
      formData.append(
        'applied_position_id',
        this.candidate.appliedPosition.value
      )
      const arr = this.candidate.skills
      for (let i = 0; i < arr.length; i++) {
        formData.append('skills[]', arr[i])
      }
      // formData.append('skills', JSON.stringify(this.candidate.skills))
      formData.append('email', this.candidate.email)
      formData.append('phone', this.candidate.phone)
      formData.append('resume', this.candidate.resume)

      formData.append('_method', 'PATCH')
      console.log(formData.getAll('skills[]'))
      console.log(formData.getAll('resume'))
      await this.$axios
        .$post(`/api/v1/candidates/${this.$route.params.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        .then(() => {
          this.success = 'Candidate updated successfully'
          this.$toast.success(this.success)
          this.$fetch()
        })
        .catch((e) => {
          console.log(e.response)
          const message = e.response.data.message
          this.error = JSON.stringify(message)
          this.$toast.error(message)
        })
    },
    handleFileUpload(event) {
      const file = event.target.files[0]
      this.createBlob(file)
      this.candidate.resume = file
    },
    createBlob(file) {
      this.blob = URL.createObjectURL(file)
    },
    generateBlobFromUrl(url) {
      this.$axios.get(url).then((response) => {
        console.log(response.blob())
        this.blob = response.blob()
      })
    },
    removeFile() {
      this.blob = null
      this.candidate.resume = ''
    },
  },
}
</script>
