<script setup lang="ts">
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Teacher Dashboard', href: dashboard().url },
]

// KPI
const kpiCards = [
  { title: 'My Classes', value: 4, color: 'from-blue-500 to-cyan-400' },
  { title: 'My Subjects', value: 3, color: 'from-purple-500 to-pink-500' },
  { title: 'Total Assignments', value: 18, color: 'from-indigo-500 to-violet-500' },
  { title: 'Pending Submissions', value: 27, color: 'from-orange-500 to-red-500' },
]

// ================= GROUPS =================
const showGroupForm = ref(false)

const groups = ref([
  {
    id: 1,
    name: 'Class 10-A Science',
    class: '10-A',
    students: ['Rahim', 'Karim', 'Ayesha'],
  },
])

const newGroup = ref({
  name: '',
  class: '',
  students: '',
})

const addGroup = () => {
  groups.value.push({
    id: Date.now(),
    name: newGroup.value.name,
    class: newGroup.value.class,
    students: newGroup.value.students.split(','),
  })

  newGroup.value = { name: '', class: '', students: '' }
  showGroupForm.value = false
}

// ================= ASSIGNMENTS =================
const showAssignmentForm = ref(false)

const assignments = ref([
  {
    title: 'Algebra Worksheet',
    group: 'Class 10-A Science',
    due: '25 Jan',
  },
])

const newAssignment = ref({
  title: '',
  group: '',
  due: '',
})

const addAssignment = () => {
  assignments.value.push({ ...newAssignment.value })
  newAssignment.value = { title: '', group: '', due: '' }
  showAssignmentForm.value = false
}

// ================= SCHEDULE =================
const schedule = ref([
  { time: '09:00 - 10:00', subject: 'Math', class: '10-A' },
])
</script>


<template>
  <Head title="Teacher Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-8 p-4">

      <!-- KPI -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div
          v-for="card in kpiCards"
          :key="card.title"
          class="rounded-xl p-4 text-white shadow bg-gradient-to-r"
          :class="card.color"
        >
          <p class="text-sm opacity-80">{{ card.title }}</p>
          <p class="mt-2 text-3xl font-bold">{{ card.value }}</p>
        </div>
      </div>

      <!-- ================= GROUPS ================= -->
      <div class="rounded-xl bg-white p-6 shadow">
        <div class="mb-4 flex justify-between">
          <h2 class="text-xl font-semibold">My Groups</h2>
          <button
            @click="showGroupForm = !showGroupForm"
            class="rounded-lg bg-blue-600 px-4 py-2 text-white"
          >
            ➕ Create Group
          </button>
        </div>

        <div v-if="showGroupForm" class="mb-4 space-y-2">
          <input v-model="newGroup.name" placeholder="Group Name" class="w-full border p-2 rounded" />
          <input v-model="newGroup.class" placeholder="Class" class="w-full border p-2 rounded" />
          <input v-model="newGroup.students" placeholder="Students (Rahim,Karim)" class="w-full border p-2 rounded" />
          <button @click="addGroup" class="w-full bg-green-600 text-white py-2 rounded">
            Save Group
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div
            v-for="g in groups"
            :key="g.id"
            class="rounded-lg border p-4"
          >
            <h3 class="font-semibold">{{ g.name }}</h3>
            <p class="text-sm text-gray-500">Class: {{ g.class }}</p>
            <p class="text-sm text-gray-500">Students: {{ g.students.length }}</p>
          </div>
        </div>
      </div>

      <!-- ================= ASSIGNMENTS ================= -->
      <div class="rounded-xl bg-white p-6 shadow">
        <div class="mb-4 flex justify-between">
          <h2 class="text-xl font-semibold">Assignments (Group-wise)</h2>
          <button
            @click="showAssignmentForm = !showAssignmentForm"
            class="rounded-lg bg-purple-600 px-4 py-2 text-white"
          >
            ➕ Create Assignment
          </button>
        </div>

        <div v-if="showAssignmentForm" class="mb-4 space-y-2">
          <input v-model="newAssignment.title" placeholder="Assignment Title" class="w-full border p-2 rounded" />
          <select v-model="newAssignment.group" class="w-full border p-2 rounded">
            <option value="">Select Group</option>
            <option v-for="g in groups" :key="g.id" :value="g.name">
              {{ g.name }}
            </option>
          </select>
          <input v-model="newAssignment.due" placeholder="Due Date" class="w-full border p-2 rounded" />
          <button @click="addAssignment" class="w-full bg-green-600 text-white py-2 rounded">
            Save Assignment
          </button>
        </div>

        <ul class="space-y-2">
          <li
            v-for="a in assignments"
            :key="a.title"
            class="rounded border p-3"
          >
            <b>{{ a.title }}</b>  
            <div class="text-sm text-gray-500">
              Group: {{ a.group }} | Due: {{ a.due }}
            </div>
          </li>
        </ul>
      </div>

    </div>
  </AppLayout>
</template>
