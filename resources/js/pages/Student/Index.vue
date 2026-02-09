<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { computed } from 'vue'

/* ================= DUMMY DATA ================= */

const props = defineProps({
  user: Object,
  student: Object,
  stats: Array,
  assignments: Array,
})

// Student basic info
const studentInfo = {
  name: 'Alex Ganesh',
  student_id: 'STD-2026-3572',
  roll: 3223,
  course: 'BCA',
  semester: '1st Semester',
  section: 'A',
}

// KPI stats
const stats = {
  attendance: props.stats.attendance,
  submitted: props.stats.submitted,
  pending: props.stats.pending,
  examStatus: props.stats.examStatus,
}

/* ================= KPI ================= */
const kpiCards = computed(() => [
  {
    title: 'My Class',
    value: `${studentInfo.course} · ${studentInfo.section}`,
    color: 'from-blue-500 to-cyan-400',
  },
  {
    title: 'Attendance %',
    value: `${stats.attendance}%`,
    color: 'from-indigo-500 to-violet-500',
  },
  {
    title: 'Submitted',
    value: stats.submitted,
    color: 'from-green-500 to-emerald-400',
  },
  {
    title: 'Pending',
    value: stats.pending,
    color: 'from-orange-500 to-red-400',
  },
  {
    title: 'Exam Status',
    value: stats.examStatus,
    color: stats.examStatus === 'Eligible'
      ? 'from-emerald-500 to-teal-400'
      : 'from-red-500 to-orange-500',
  },
])


</script>

<template>

  <Head title="Student Dashboard" />

  <AppLayout>
    <div class="p-4 space-y-8">
      <!-- ================= STUDENT HEADER ================= -->
      <div class="rounded-xl bg-white p-5 shadow flex flex-col gap-1">
        <h2 class="text-xl font-semibold text-gray-800">
          👋 Welcome, {{ props.user.name }}
        </h2>
        <p class="text-sm text-gray-500">
          {{ props.student.course }} · {{ props.student.semester }} · Section {{ props.student.section }}
        </p>
        <p class="text-sm text-gray-500">
          Roll: {{ props.student.roll }} | StudentID: {{ props.student.student_id }}
        </p>
      </div>
      <!-- ================= KPI CARDS ================= -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div v-for="card in kpiCards" :key="card.title" class="rounded-xl p-4 text-white shadow bg-gradient-to-r"
          :class="card.color">
          <p class="text-sm opacity-80">
            {{ card.title }}
          </p>
          <p class="mt-2 text-2xl font-bold">
            {{ card.value }}
          </p>
        </div>
      </div>

      <!-- ================= ASSIGNMENTS ================= -->
      <div class="rounded-xl bg-white shadow">
        <div class="border-b px-4 py-3 flex justify-between items-center">
          <h3 class="text-sm font-semibold text-gray-700">
            📄 My Assignments
          </h3>
          <Link href="#" class="text-sm text-indigo-600 hover:underline">
            View All
          </Link>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
              <tr>
                <th class="px-4 py-3 text-left">Title</th>
                <th class="px-4 py-3 text-left">Subject</th>
                <th class="px-4 py-3 text-center">Due Date</th>
                <th class="px-4 py-3 text-center">Marks</th>
                <th class="px-4 py-3 text-right">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y">
              <tr v-for="a in props.assignments" :key="a.id" class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium text-gray-800">
                  {{ a.title }}
                </td>
                <td class="px-4 py-3 text-gray-600">
                  {{ a.subject }}
                </td>
                <td class="px-4 py-3 text-center text-gray-600">
                  {{ a.due_date }}
                </td>
                <td class="px-4 py-3 text-center">

                  <!-- Show marks ONLY if graded -->
                  <span v-if="a.marks !== null" class="font-semibold text-green-700">
                    {{ a.marks }}
                  </span>
                  <span v-else-if="a.status == 'Late'" class="font-semibold text-red-700">
                    0
                  </span>


                  <!-- Otherwise show nothing / dash -->
                  <span v-else class="text-gray-400 text-xs">
                    —
                  </span>

                </td>
                <td class="px-4 py-3 text-right">

                  <!-- Graded (highest priority) -->
                  <span v-if="a.marks !== null"
                    class="rounded-full px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700">
                    Graded
                  </span>

                  <!-- Submitted but not graded -->
                  <span v-else-if="a.status === 'Submitted'"
                    class="rounded-full px-3 py-1 text-xs font-medium bg-green-100 text-green-700">
                    Submitted
                  </span>

                  <!-- Late -->
                  <span v-else-if="a.status === 'Late'"
                    class="rounded-full px-3 py-1 text-xs font-medium bg-red-100 text-red-700">
                    Fail
                  </span>

                  <!-- Pending -->
                  <Link v-else :href="`/student/assignments/${a.id}`"
                    class="text-indigo-600 hover:underline text-sm font-medium">
                    Submit
                  </Link>

                </td>


              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </AppLayout>
</template>
