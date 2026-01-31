<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head } from '@inertiajs/vue3'

/* ---------------- Breadcrumbs ---------------- */
const breadcrumbs = [
  {
    title: 'Student List',
    href: dashboard().url,
  },
]

/* ---------------- Props ---------------- */
const props = defineProps({
  list:Object
})

</script>

<template>
  <Head title="Student List" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4 rounded-xl p-4">

      <!-- Section Info -->
      <div class="rounded-lg bg-gray-50 p-4">
        <h2 class="text-lg font-semibold">
          Section: {{ list.name }}

        </h2>
        <p class="text-sm text-gray-600">
          Total Students: {{ list.students.length }}
        </p>
      </div>

      <!-- Student Attendance Style Table -->
      <div class="overflow-x-auto rounded-lg border">
        <table class="w-full text-sm">
          <thead class="bg-gray-100 text-left">
            <tr>
              <th class="px-4 py-2">Roll</th>
              <th class="px-4 py-2">Name</th>
              <th class="px-4 py-2">Email</th>
              <th class="px-4 py-2">Program</th>
              <th class="px-4 py-2">Year</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2 text-center">Attendance</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="student in list.students"
              :key="student.id"
              class="border-t hover:bg-gray-50"
            >
              <td class="px-4 py-2">
                {{ student.roll_number ?? 'N/A' }}
              </td>

              <td class="px-4 py-2">
                {{ student.user.name }}
              </td>

              <td class="px-4 py-2">
                {{ student.user.email }}
              </td>

              <td class="px-4 py-2">
                {{ student.program ?? '—' }}
              </td>

              <td class="px-4 py-2">
                {{ student.admission_year ?? '—' }}
              </td>

              <td class="px-4 py-2">
                <span
                  class="rounded px-2 py-1 text-xs"
                  :class="student.status
                    ? 'bg-green-100 text-green-700'
                    : 'bg-red-100 text-red-700'"
                >
                  {{ student.status ? 'Active' : 'Inactive' }}
                </span>
              </td>

              <!-- Attendance checkbox (future ready) -->
              <td class="px-4 py-2 text-center">
                <input
                  type="checkbox"
                  class="h-4 w-4"
                />
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </AppLayout>
</template>
