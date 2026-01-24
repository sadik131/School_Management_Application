<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const breadcrumbs = [
  { title: 'Profile', href: dashboard().url },
]

// props from backend
const { profile } = defineProps({
  profile: Object,
})

// Tabs
const activeTab = ref('basic')

// Edit Modal
const showEditModal = ref(false)
const editProfile = ref(JSON.parse(JSON.stringify(profile)))

const openEditModal = () => {
  editProfile.value = JSON.parse(JSON.stringify(profile))
  showEditModal.value = true
}

const closeEditModal = () => {
  showEditModal.value = false
}

// 🔥 teacher basic update only
const saveProfileFromModal = () => {
  router.put('/teacher/profile/basic', editProfile.value.basic, {
    onSuccess: () => {
      showEditModal.value = false
    },
  })
}
</script>

<template>
  <Head title="Teacher Profile" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-5xl w-full mx-auto space-y-6">

      <!-- HEADER -->
      <div class="bg-white rounded-xl shadow p-6 flex items-center justify-between">
        <div class="flex items-center gap-6">
          <img
            src="https://i.pravatar.cc/150?img=12"
            class="w-24 h-24 rounded-full border"
          />
          <div>
            <h2 class="text-2xl font-bold">
              {{ profile.basic.name }}
            </h2>

            <p class="text-gray-600">
              Teacher • {{ profile.academic?.department ?? 'Not Assigned' }}
            </p>
          </div>
        </div>

        <button
          @click="openEditModal"
          class="px-3 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700"
        >
          ✏️ Edit
        </button>
      </div>

      <!-- TABS -->
      <div class="flex gap-4">
        <button
          @click="activeTab = 'basic'"
          class="px-4 py-2 rounded-lg"
          :class="activeTab === 'basic'
            ? 'bg-blue-600 text-white'
            : 'bg-white shadow'"
        >
          Basic Info
        </button>

        <button
          @click="activeTab = 'academic'"
          class="px-4 py-2 rounded-lg"
          :class="activeTab === 'academic'
            ? 'bg-blue-600 text-white'
            : 'bg-white shadow'"
        >
          Academic Info
        </button>
      </div>

      <!-- CONTENT -->
      <div class="bg-white rounded-xl shadow p-6">

        <!-- BASIC INFO -->
        <div v-if="activeTab === 'basic'" class="grid md:grid-cols-2 gap-4">
          <p><b>Email:</b> {{ profile.basic.email }}</p>
          <p><b>Phone:</b> {{ profile.basic.phone ?? '—' }}</p>
          <p><b>Gender:</b> {{ profile.basic.gender ?? '—' }}</p>
          <p><b>DOB:</b> {{ profile.basic.dob ?? '—' }}</p>
          <p><b>Blood Group:</b> {{ profile.basic.blood ?? '—' }}</p>
          <p class="md:col-span-2">
            <b>Address:</b> {{ profile.basic.address ?? '—' }}
          </p>
        </div>

        <!-- ACADEMIC (READ ONLY) -->
        <div v-if="activeTab === 'academic'">
          <div v-if="profile.academic" class="space-y-3">
            <p><b>Designation:</b> {{ profile.academic.designation }}</p>
            <p><b>Department:</b> {{ profile.academic.department }}</p>
            <p><b>Qualification:</b> {{ profile.academic.qualification }}</p>
            <p><b>Join:</b> {{ profile.academic.experience }}</p>
          </div>

          <div v-else class="text-sm text-gray-500 italic">
            Academic information not assigned by admin yet.
          </div>
        </div>

      </div>

      <!-- EDIT MODAL -->
      <div
  v-if="showEditModal"
  class="fixed inset-0 z-50 flex items-center justify-center bg-black/60"
>
  <div
    class="bg-white w-full min-h-[60vh] max-h-[90vh] overflow-y-scroll
           max-w-xl rounded-2xl shadow-2xl overflow-hidden"
  >

    <!-- Header -->
    <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50">
      <div>
        <h3 class="text-lg font-semibold text-gray-800">
          Edit Profile
        </h3>
        <p class="text-xs text-gray-500">
          Update your basic personal information
        </p>
      </div>
      <button
        @click="closeEditModal"
        class="text-gray-400 hover:text-gray-600 text-xl"
      >
        ✕
      </button>
    </div>

    <!-- Body -->
    <div class="px-6 py-6 text-sm">
      <div class="rounded-xl bg-gray-50 p-6 space-y-6">

        <div>
          <h4 class="text-sm font-semibold text-gray-800">
            Personal Information
          </h4>
          <p class="text-xs text-gray-500">
            Update your basic profile details
          </p>
        </div>

        <div class="grid grid-cols-2 gap-5">

          <div class="col-span-2">
            <label class="text-xs">Full Name</label>
            <input v-model="editProfile.basic.name" class="w-full border p-2 rounded" />
          </div>

          <div>
            <label class="text-xs">Email</label>
            <input disabled v-model="editProfile.basic.email"
              class="w-full border p-2 rounded bg-gray-200" />
          </div>

          <div>
            <label class="text-xs">Phone</label>
            <input v-model="editProfile.basic.phone" class="w-full border p-2 rounded" />
          </div>

          <select v-model="editProfile.basic.gender" class="w-full border p-2 rounded">
            <option value="">Select gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>

          <input type="date" v-model="editProfile.basic.dob" class="w-full border p-2 rounded" />
          <input v-model="editProfile.basic.blood" class="w-full border p-2 rounded" />

          <textarea
            v-model="editProfile.basic.address"
            rows="3"
            class="col-span-2 w-full border p-2 rounded"
          />
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50">
      <button @click="closeEditModal" class="px-4 py-2 bg-gray-200 rounded">
        Cancel
      </button>
      <button
        @click="saveProfileFromModal"
        class="px-5 py-2 bg-indigo-600 text-white rounded"
      >
        Save Changes
      </button>
    </div>

  </div>
</div>


    </div>
  </AppLayout>
</template>
