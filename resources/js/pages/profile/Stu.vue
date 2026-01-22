<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue'

const breadcrumbs = [
  {
    title: 'Profile',
    href: dashboard().url,
  },
]

// Tabs
const activeTab = ref('basic')

// Dummy Student Profile Data
const profile = {
  basic: {
    name: 'Amit Kumar',
    email: 'amit.student@school.com',
    phone: '+91 99887 66554',
    gender: 'Male',
    dob: '2003-04-18',
    blood: 'B+',
    address: 'Patna, Bihar',
  },

  academic: {
    studentId: 'STD-2023-045',
    course: 'BCA',
    section: 'A',
    semester: '5th',
    rollNumber: 'BCA-5A-23',
  },

  activity: {
    attendance: {
      percentage: '78%',
      classesAttended: 94,
      totalClasses: 120,
    },
    assignments: {
      submitted: 18,
      pending: 4,
      late: 2,
    },
    examStatus: {
      eligible: true,
      detained: false,
    },
  },
}
</script>

<template>
  <Head title="Student Profile" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-5xl w-full mx-auto space-y-6">

      <!-- Header -->
      <div class="bg-white rounded-xl shadow p-6 flex items-center gap-6">
        <img
          src="https://i.pravatar.cc/150?img=32"
          class="w-24 h-24 rounded-full border"
        />
        <div>
          <h2 class="text-2xl font-bold">{{ profile.basic.name }}</h2>
          <p class="text-gray-600">
            Student • {{ profile.academic.course }} (Section {{ profile.academic.section }})
          </p>

          <span
            class="inline-block mt-2 px-3 py-1 text-sm rounded-full"
            :class="profile.activity.examStatus.eligible
              ? 'bg-green-100 text-green-700'
              : 'bg-red-100 text-red-700'"
          >
            {{ profile.activity.examStatus.eligible ? 'Exam Eligible' : 'Detained' }}
          </span>
        </div>
      </div>

      <!-- Tabs -->
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

        <button
          @click="activeTab = 'activity'"
          class="px-4 py-2 rounded-lg"
          :class="activeTab === 'activity'
            ? 'bg-blue-600 text-white'
            : 'bg-white shadow'"
        >
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
              <span
                :class="profile.activity.examStatus.eligible
                  ? 'text-green-600 font-semibold'
                  : 'text-red-600 font-semibold'"
              >
                {{ profile.activity.examStatus.eligible ? 'Eligible' : 'Detained' }}
              </span>
            </p>
          </div>

        </div>

      </div>
    </div>
  </AppLayout>
</template>
