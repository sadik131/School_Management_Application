<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'

const breadcrumbs = [
  { title: 'Profile', href: dashboard().url },
]

// props
const { profile } = defineProps({
  profile: {
    type: Object,
    required: true,
  },
})

// Tabs
const activeTab = ref('basic')

// Edit Modal
const showEditModal = ref(false)

// editable copy (SAFE)
const editProfile = ref(JSON.parse(JSON.stringify(profile)))

const openEditModal = () => {
  editProfile.value = JSON.parse(JSON.stringify(profile))
  showEditModal.value = true
}

const closeEditModal = () => {
  showEditModal.value = false
}

const saveProfileFromModal = () => {
  router.put('/student/profile/basic', editProfile.value.basic, {
    onSuccess: () => {
      showEditModal.value = false
    },
  })
}
</script>


<template>

  <Head title="Student Profile" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-5xl w-full mx-auto space-y-6">

      <!-- Header -->
      <div class="bg-white rounded-xl shadow p-6 flex items-center justify-between">
        <div class="flex items-center gap-6">
          <img src="https://i.pravatar.cc/150?img=32" class="w-24 h-24 rounded-full border" />
          <div>
            <h2 class="text-2xl font-bold">{{ profile.basic.name }}</h2>
            <p class="text-gray-600">
              Student • {{ profile.academic.course }} (Section {{ profile.academic.section }})
            </p>

            <span class="inline-block mt-2 px-3 py-1 text-sm rounded-full" :class="profile.activity.examStatus.eligible
              ? 'bg-green-100 text-green-700'
              : 'bg-red-100 text-red-700'">
              {{ profile.activity.examStatus.eligible ? 'Exam Eligible' : 'Detained' }}
            </span>
          </div>
        </div>

        <!-- Small Edit Button -->
        <button @click="openEditModal"
          class="px-3 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
          ✏️ Edit
        </button>
      </div>


      <!-- Tabs -->
      <div class="flex gap-4">
        <button @click="activeTab = 'basic'" class="px-4 py-2 rounded-lg" :class="activeTab === 'basic'
          ? 'bg-blue-600 text-white'
          : 'bg-white shadow'">
          Basic Info
        </button>

        <button @click="activeTab = 'academic'" class="px-4 py-2 rounded-lg" :class="activeTab === 'academic'
          ? 'bg-blue-600 text-white'
          : 'bg-white shadow'">
          Academic Info
        </button>

        <button @click="activeTab = 'activity'" class="px-4 py-2 rounded-lg" :class="activeTab === 'activity'
          ? 'bg-blue-600 text-white'
          : 'bg-white shadow'">
          Activity
        </button>
      </div>

      <!-- Content -->
      <div class="bg-white rounded-xl shadow p-6">

        <!-- Basic Info -->
        <div v-if="activeTab === 'basic'" class="grid md:grid-cols-2 gap-4">
          <p><b>Email:</b> {{ profile.basic.email }}</p>
          <p><b>Phone:</b> {{ profile.basic.phone }}</p>
          <p><b>Gender:</b> {{ profile.basic.gender }}</p>
          <p><b>DOB:</b> {{ profile.basic.dob }}</p>
          <p><b>Blood Group:</b> {{ profile.basic.blood }}</p>
          <p class="md:col-span-2">
            <b>Address:</b> {{ profile.basic.address }}
          </p>
        </div>

        <!-- Academic Info -->
        <div v-if="activeTab === 'academic'" class="space-y-3">
          <p><b>Student ID:</b> {{ profile.academic.studentId }}</p>
          <p><b>Roll Number:</b> {{ profile.academic.rollNumber }}</p>
          <p><b>Course:</b> {{ profile.academic.course }}</p>
          <p><b>Section:</b> {{ profile.academic.section }}</p>
          <p><b>Semester:</b> {{ profile.academic.semester }}</p>
        </div>

        <!-- Activity -->
        <div v-if="activeTab === 'activity'" class="grid md:grid-cols-3 gap-4">

          <div class="border rounded-lg p-4">
            <h4 class="font-semibold mb-2">Attendance</h4>
            <p>Attendance: {{ profile.activity.attendance.percentage }}</p>
            <p>Attended: {{ profile.activity.attendance.classesAttended }}</p>
            <p>Total Classes: {{ profile.activity.attendance.totalClasses }}</p>
          </div>

          <div class="border rounded-lg p-4">
            <h4 class="font-semibold mb-2">Assignments</h4>
            <p>Submitted: {{ profile.activity.assignments.submitted }}</p>
            <p>Pending: {{ profile.activity.assignments.pending }}</p>
            <p>Late: {{ profile.activity.assignments.late }}</p>
          </div>

          <div class="border rounded-lg p-4">
            <h4 class="font-semibold mb-2">Exam Status</h4>
            <p>
              Status:
              <span :class="profile.activity.examStatus.eligible
                ? 'text-green-600 font-semibold'
                : 'text-red-600 font-semibold'">
                {{ profile.activity.examStatus.eligible ? 'Eligible' : 'Detained' }}
              </span>
            </p>
          </div>

        </div>
        <!-- ================= EDIT PROFILE MODAL ================= -->
        <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60">
          <div class="bg-white w-full  min-h-[60vh] max-h-[90vh] overflow-y-scroll max-w-xl rounded-2xl shadow-2xl
           overflow-hidden">

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
              <button @click="closeEditModal" class="text-gray-400 hover:text-gray-600 text-xl">
                ✕
              </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-6 text-sm">

              <div class="rounded-xl
 bg-gray-50 p-6 space-y-6">

                <!-- Section Header -->
                <div>
                  <h4 class="text-sm font-semibold text-gray-800">
                    Personal Information
                  </h4>
                  <p class="text-xs text-gray-500">
                    Update your basic profile details
                  </p>
                </div>

                <!-- Form -->
                <div class="grid grid-cols-2 gap-5">

                  <!-- Full Name -->
                  <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                      Full Name
                    </label>
                    <input v-model="editProfile.basic.name" type="text" placeholder="Enter full name" class="w-full rounded-lg bg-white border border-gray-300
                 px-3 py-2 text-sm text-gray-800
                 placeholder-gray-400
                 hover:border-gray-400
                 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500" />
                  </div>

                  <!-- Email -->
                  <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                      Email Address
                    </label>
                    <input disabled="true" v-model="editProfile.basic.email" type="email"
                      placeholder="example@email.com" class="w-full rounded-lg disabled:bg-gray-300 disabled:cursor-not-allowed bg-white border border-gray-300
                 px-3 py-2 text-sm
                 hover:border-gray-400
                 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500" />
                  </div>

                  <!-- Phone -->
                  <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                      Phone Number
                    </label>
                    <input v-model="editProfile.basic.phone" type="text" placeholder="+91 XXXXX XXXXX" class="w-full rounded-lg bg-white border border-gray-300
                 px-3 py-2 text-sm
                 hover:border-gray-400
                 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500" />
                  </div>

                  <!-- Gender -->
                  <select v-model="editProfile.basic.gender" class="w-full rounded-lg bg-white border border-gray-300
         px-3 py-1 text-sm
         focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">
                    <option value="">Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>

                  <!-- DOB -->
                  <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                      Date of Birth
                    </label>
                    <input v-model="editProfile.basic.dob" type="date" class="w-full rounded-lg bg-white border border-gray-300
                 px-3 py-2 text-sm
                 hover:border-gray-400
                 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500" />
                  </div>

                  <!-- Blood Group -->
                  <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                      Blood Group
                    </label>
                    <input v-model="editProfile.basic.blood" type="text" placeholder="e.g. B+" class="w-full rounded-lg bg-white border border-gray-300
                 px-3 py-2 text-sm
                 hover:border-gray-400
                 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500" />
                  </div>

                  <!-- Address -->
                  <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                      Address
                    </label>
                    <textarea v-model="editProfile.basic.address" rows="3" placeholder="Enter full address" class="w-full rounded-lg bg-white border border-gray-300
                 px-3 py-2 text-sm resize-none
                 hover:border-gray-400
                 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500" />
                  </div>

                </div>
              </div>

            </div>


            <!-- Footer -->
            <div class="flex justify-end gap-3 px-6 py-4 border-t bg-gray-50">
              <button @click="closeEditModal" class="px-4 py-2 text-sm rounded-lg bg-gray-200 hover:bg-gray-300">
                Cancel
              </button>
              <button @click="saveProfileFromModal"
                class="px-5 py-2 text-sm rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                Save Changes
              </button>
            </div>

          </div>
        </div>

      </div>
    </div>
  </AppLayout>
</template>
