<script setup>
import { computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link } from '@inertiajs/vue3'
import { BookMinus, Eye, Trash } from 'lucide-vue-next'

/* ================= BREADCRUMB ================= */
const breadcrumbs = [
  { title: 'Teacher Dashboard', href: dashboard().url },
]

/* ================= PROPS ================= */
const props = defineProps({
  stats: Object,
  myClasses: {
    type: Array,
    default: () => [],
  },
})

/* ================= COMPUTED KPI ================= */

// total students across all assigned sections
const totalStudents = computed(() =>
  props.myClasses.reduce(
    (sum, section) =>
      sum + (section.students_count ?? section.students?.length ?? 0),
    0
  )
)

// unique courses teacher teaches
const totalCourses = computed(() => {
  const courseIds = props.myClasses.map(
    section => section.semester?.course?.id
  )
  return new Set(courseIds).size
})

const kpiCards = computed(() => [
  {
    title: 'My Classes',
    value: props.myClasses.length,
    color: 'from-blue-500 to-cyan-400',
  },
  {
    title: 'Total Students',
    value: totalStudents.value,
    color: 'from-indigo-500 to-violet-500',
  },
  {
    title: 'Total Assignment',
    value: props.stats?.total_assignments ,
    color: 'from-emerald-500 to-teal-400',
  },
  {
    title: 'Submitted',
    value: props.stats?.submitted ?? 0,
    color: 'from-green-500 to-emerald-400',
  },
  {
    title: 'Pending',
    value: props.stats?.pending ?? 0,
    color: 'from-orange-500 to-red-400',
  },
])
</script>

<template>

  <Head title="Teacher Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-8 p-4">
      <!-- ================= KPI ================= -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="card in kpiCards" :key="card.title" class="rounded-xl p-4 text-white shadow bg-linear-to-r"
          :class="card.color">
          <p class="text-sm opacity-80">
            {{ card.title }}
          </p>
          <p class="mt-2 text-3xl font-bold">
            {{ card.value }}
          </p>
        </div>
      </div>
      <!-- ================= TABLES ================= -->
      <div class="flex w-full gap-4">

        <!-- ================= ASSIGNMENT OVERVIEW ================= -->
        <div class="rounded-xl bg-white shadow w-full h-[50vh] overflow-y-auto">
          <div class="sticky top-0 z-20 border-b px-4 py-3 bg-white">
            <h2 class="text-sm font-semibold text-gray-700">
              Class Overview
            </h2>
          </div>

          <table class="w-full text-sm">
            <thead class="sticky top-0 z-10 bg-gray-50 text-gray-600">
              <tr>
                <th class="px-4 py-3 text-left font-medium">Class</th>
                <th class="px-4 py-3 text-center font-medium">Total Students</th>
                <th class="px-4 py-3 text-center font-medium">Action</th>
              </tr>
            </thead>

            <tbody class="divide-y">
              <tr v-for="section in myClasses" :key="section.id" class="hover:bg-gray-50">
                <td class="px-4 py-3">
                  {{ section.semester.course.code }}
                  · {{ section.semester.name }}
                  · Section {{ section.name }}
                </td>

                <td class="px-4 py-3 text-center font-semibold">
                  {{ section.students_count ?? section.students.length }}
                </td>
                <td class="flex gap-2 px-4 py-3 text-right">
                  <Link :href="`/teacher/section/${section.id}`"
                    class="text-yellow-600 hover:underline font-medium">
                    <Eye class="w-5 h-5" />
                  </Link>
                  <Link :href="`/teacher/assignments/create?section=${section.id}`"
                    class="text-indigo-600 hover:underline font-medium">
                    <BookMinus class="w-5 h-5" />
                  </Link>
                  <!-- <Link :href="`/teacher/assignments/create?section=${section.id}`"
                    class="text-red-600 hover:underline font-medium">
                    <Trash class="w-5 h-5"/> 
                  </Link> -->
                </td>
                
              </tr>

              <tr v-if="!myClasses.length">
                <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                  No classes available
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- ================= TEACHING OVERVIEW ================= -->
        <div class="rounded-xl bg-white shadow w-full h-[50vh] overflow-y-auto">
          <div class="sticky top-0 z-20 border-b px-4 py-3 bg-white">
            <h2 class="text-sm font-semibold text-gray-700">
              Assignment Overview
            </h2>
          </div>

          <table class="w-full text-sm">
            <thead class="sticky top-0 z-10 bg-gray-50 text-gray-600">
              <tr>
                <th class="px-4 py-3 text-left font-medium">Course</th>
                <th class="px-4 py-3 text-left font-medium">Students</th>
                <th class="px-4 py-3 text-left font-medium">Submit</th>
                <th class="px-4 py-3 text-left font-medium">Pending</th>
              </tr>
            </thead>

            <tbody class="divide-y">
              <tr v-for="section in myClasses" :key="section.id" class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">
                  {{ section.semester.course.code }} - {{ section.semester.number }}{{ section.name }}
                </td>

                <td class="px-4 py-3">
                  {{ section.students_count ?? section.students.length }}
                </td>

                <td class="px-4 py-3">
                  {{ section.submissions_count ?? 0 }}
                </td>

                <td class="px-4 py-3 text-left text-red-400 font-semibold">
                   {{ section.pending  ?? 0 }}
                </td>
              </tr>

              <tr v-if="!myClasses.length">
                <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                  No sections assigned yet
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </AppLayout>
</template>
