<template>
  <div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md mx-auto mt-8 p-6 bg-white rounded-lg">
      <h1 class="text-2xl font-semibold mb-4">Resume Form</h1>
      <form @submit.prevent="submitForm">
        <div class="border-b border-gray-900/10 pb-12">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name:</label>
            <div class="mt-2">
              <input id="name" v-model="formData.name" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="sm:col-span-4 mb-4">
            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email:</label>
            <div class="mt-2">
              <input id="email" v-model="formData.email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
          </div>

          <div class="sm:col-span-4 mb-4">
            <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone:</label>
            <input id="phone" v-model="formData.phone" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
          </div>

          <div class="col-span-full">
            <label for="resume-form" class="block text-sm font-medium leading-6 text-gray-900">Resume (PDF only):</label>
            <div v-if="!formData.resume" class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
              <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="mx-auto h-12 w-12 text-gray-500" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                </svg>
                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                  <label for="resume" class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-600 focus-within:ring-offset-2 hover:text-blue-500">
                    <span>Upload a file</span>
                    <input id="resume" type="file" required class="sr-only" @change="handleFileChange" />
                  </label>
                  <p class="pl-1">or drag and drop</p>
                </div>
                <p class="text-xs leading-5 text-gray-600">PDF up to 10MB</p>
              </div>
            </div>
            <div v-if="formData.resume">
              <p class="mt-2 text-sm text-gray-600">{{ formData.resume.name }}</p>
              <button type="button" class="mt-2 text-sm text-red-600 cursor-pointer" @click="clearFile">Clear</button>
            </div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
          <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Submit</button>
        </div>
      </form>

      <!-- Toaster Notification -->
      <div v-if="isSubmitted" class="fixed top-4 right-4 md:right-8 lg:right-16 z-50">
        <div class="flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-gray-500 bg-gray-100 divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow space-x" role="alert">
          <svg class="w-5 h-5 text-blue-600 rotate-45" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9" />
          </svg>
          <div class="ps-4 text-sm font-normal">
            Resume submitted successfully! Thank you.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        name: '',
        email: '',
        phone: '',
        resume: null,
      },
      isSubmitted: false,
    }
  },
  methods: {
    async submitForm() {
      // handle form submission
      await this.$inertia.post(route('resume.store'), this.formData)

      // clear form data on successful submission
      this.formData = {
        name: '',
        email: '',
        phone: '',
        resume: null,
      }

      // flag to show the toaster
      this.isSubmitted = true

      setTimeout(() => {
        this.isSubmitted = false
      }, 3000)
    },

    handleFileChange(event) {
      this.formData.resume = event.target.files[0]
    },

    clearFile() {
      this.formData.resume = null
    },
  },
}
</script>
