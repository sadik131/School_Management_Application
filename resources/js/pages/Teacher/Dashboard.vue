<script setup>
import { computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link } from '@inertiajs/vue3'

/* ================= BREADCRUMB ================= */
const breadcrumbs= [
  { title: 'Teacher Dashboard', href: dashboard().url },
]

/* ================= PROPS ================= */
const props = defineProps({
  stats: Object,
  myClasses: Array,
})

/* ================= KPI ================= */
const kpiCards = computed(() => [
  {
    title: 'My Classes',
    value: props.stats?.total_sections ?? 0,
    color: 'from-blue-500 to-cyan-400',
  },
  {
    title: 'Total Assignments',
    value: 18, // dummy
    color: 'from-indigo-500 to-violet-500',
  },
  {
    title: 'Pending Submissions',
    value: 27, // dummy
    color: 'from-orange-500 to-red-500',
  },
])
</script>

<template>

  <Head title="Teacher Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-8 p-4">

      <!-- ================= KPI ================= -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div v-for="card in kpiCards" :key="card.title" class="rounded-xl p-4 text-white shadow bg-gradient-to-r"
          :class="card.color">
          <p class="text-sm opacity-80">
            {{ card.title }}
          </p>
          <p class="mt-2 text-3xl font-bold">
            {{ card.value }}
          </p>
        </div>
      </div>
{{ myClasses }}
      <div class="flex w-full gap-4 ">
        <div class="rounded-xl bg-white shadow w-full h-[50vh] overflow-y-scroll">
          <div class="sticky top-0 z-20 border-b px-4 py-3">
            <h2 class="text-sm font-semibold text-gray-700">
              Teaching Overview
            </h2>
          </div>

          <div class="overflow-x-auto h-[calc(50vh-48px)]">
            <table class="w-full text-sm">
              <thead class="sticky top-0 z-10 bg-gray-50 text-gray-600">
                <tr>
                  <th class="px-4 py-3 text-left font-medium">Course</th>
                  <th class="px-4 py-3 text-left font-medium">Semester</th>
                  <th class="px-4 py-3 text-left font-medium">Section</th>
                  <th class="px-4 py-3 text-right font-medium">Students</th>
                </tr>
              </thead>

              <tbody class="divide-y">
                <tr v-for="section in myClasses" :key="section.id" class="hover:bg-gray-50">
                  <td class="px-4 py-3">
                    {{ section.semester.course.name }}
                  </td>

                  <td class="px-4 py-3">
                    {{ section.semester.name }}
                  </td>

                  <td class="px-4 py-3">
                    {{ section.name }}
                  </td>

                  <td class="px-4 py-3 text-right text-gray-600">
                    {{ section.capacity }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="rounded-xl bg-white shadow w-full h-[50vh] overflow-y-scroll">
          <div class="sticky top-0 z-20 border-b px-4 py-3">
            <h2 class="text-sm font-semibold text-gray-700">
              Assignment Overview
            </h2>
          </div>

          <div class="h-[calc(50vh-48px)] overflow-x-auto">
            <table class="w-full text-sm">
              <thead class="sticky top-0 z-10 bg-gray-50 text-gray-600">
                <tr>
                  <th class="px-4 py-3 text-left font-medium">Class</th>
                  <th class="px-4 py-3 text-center font-medium">Submitted</th>
                  <th class="px-4 py-3 text-center font-medium">Pending</th>
                  <th class="px-4 py-3 text-right font-medium">Action</th>
                </tr>
              </thead>

              <tbody class="divide-y">
                <tr v-for="section in myClasses" :key="section.id" class="hover:bg-gray-50">
                  <td class="px-4 py-3">
                    {{ section.semester.course.name }}
                    · {{ section.semester.name }}
                    · {{ section.name }}
                  </td>

                  <td class="px-4 py-3 text-center font-medium">
                    32
                  </td>

                  <td class="px-4 py-3 text-center font-medium text-red-600">
                    8
                  </td>

                  <td class="px-4 py-3 text-right">
                    <Link :href="`/teacher/assignments/create?section=${section.id}`"
                      class="text-indigo-600 hover:underline text-sm">
                      Create
                    </Link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </AppLayout>
</template>
