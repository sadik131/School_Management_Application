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

// Dummy Profile Data
const profile = {
  basic: {
    name: 'Rahul Sharma',
    email: 'rahul.teacher@school.com',
    phone: '+91 98765 43210',
    gender: 'Male',
    dob: '1995-08-12',
    blood: 'O+',
    address: 'Kolkata, West Bengal',
  },
  academic: {
    teacherId: 'TCH-1023',
    department: 'BCA',
    designation: 'Assistant Professor',
    qualification: 'MCA',
    experience: '5 Years',
    courses: ['Web Development', 'DBMS', 'Computer Networks'],
    sections: ['A', 'B'],
  },
  activity: {
    assignments: { total: 24, checked: 18, pending: 6 },
    attendance: { classes: 120, avg: '82%' },
    students: { eligible: 48, detained: 7 },
  },
}
</script>

<template>
  <Head title="Profile" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-5xl w-full mx-auto space-y-6">

      <!-- Header -->
      <div class="bg-white rounded-xl shadow p-6 flex items-center gap-6">
        <img
          src="https://i.pravatar.cc/150?img=12"
          class="w-24 h-24 rounded-full border"
        />
        <div>
          <h2 class="text-2xl font-bold">{{ profile.basic.name }}</h2>
          <p class="text-gray-600">
            Teacher • {{ profile.academic.department }}
          </p>
          <span
            class="inline-block mt-2 px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full"
          >
            Active
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
          <p><b>Teacher ID:</b> {{ profile.academic.teacherId }}</p>
          <p><b>Designation:</b> {{ profile.academic.designation }}</p>
          <p><b>Qualification:</b> {{ profile.academic.qualification }}</p>
          <p><b>Experience:</b> {{ profile.academic.experience }}</p>

          <div>
            <b>Courses:</b>
            <span
              v-for="c in profile.academic.courses"
              :key="c"
              class="ml-2 px-3 py-1 bg-gray-200 rounded-full text-sm"
            >
              {{ c }}
            </span>
          </div>

          <div>
            <b>Sections:</b>
            <span
              v-for="s in profile.academic.sections"
              :key="s"
              class="ml-2 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm"
            >
              {{ s }}
            </span>
          </div>
        </div>

        <!-- Activity -->
        <div v-if="activeTab === 'activity'" class="grid md:grid-cols-3 gap-4">
          <div class="border rounded-lg p-4">
            <h4 class="font-semibold mb-2">Assignments</h4>
            <p>Total: {{ profile.activity.assignments.total }}</p>
            <p>Checked: {{ profile.activity.assignments.checked }}</p>
            <p>Pending: {{ profile.activity.assignments.pending }}</p>
          </div>

          <div class="border rounded-lg p-4">
            <h4 class="font-semibold mb-2">Attendance</h4>
            <p>Classes Taken: {{ profile.activity.attendance.classes }}</p>
            <p>Average: {{ profile.activity.attendance.avg }}</p>
          </div>

          <div class="border rounded-lg p-4">
            <h4 class="font-semibold mb-2">Students</h4>
            <p>Exam Eligible: {{ profile.activity.students.eligible }}</p>
            <p>Detained: {{ profile.activity.students.detained }}</p>
          </div>
        </div>

      </div>
    </div>
  </AppLayout>
</template>
