<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps({
  assignment: Object,
  results: Array,
})
</script>

<template>
  <Head title="Assignment Results" />

  <AppLayout>
    <div class="max-w-4xl w-full mx-auto p-6 space-y-4">

      <!-- Header -->
      <div class="flex justify-between items-center">
        <h2 class="text-lg font-semibold">
          Question: {{ assignment.title }}
        </h2>

        <Link
          href="/dashboard"
          class="text-sm text-gray-600 hover:underline"
        >
          ← Back
        </Link>
      </div>

      <!-- Result Table -->
      <div class="bg-white rounded-xl shadow overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-gray-50 text-gray-600">
            <tr>
              <th class="px-4 py-3 text-left">Student</th>
              <th class="px-4 py-3 text-center">Roll</th>
              <th class="px-4 py-3 text-center">Marks</th>
              <th class="px-4 py-3 text-right">Status</th>
            </tr>
          </thead>

          <tbody class="divide-y">
            <tr v-for="r in results" :key="r.roll">
              <td class="px-4 py-3 font-medium">
                {{ r.student_name }}
              </td>

              <td class="px-4 py-3 text-center">
                {{ r.roll }}
              </td>

              <td class="px-4 py-3 text-center">
                <span v-if="r.marks !== null" class="font-semibold text-green-700">
                  {{ r.marks }}
                </span>
                <span v-else class="text-gray-400">—</span>
              </td>

              <td class="px-4 py-3 text-right">
                <span
                  v-if="r.status === 'Graded'"
                  class="rounded-full bg-blue-100 px-3 py-1 text-xs text-blue-700"
                >
                  Graded
                </span>

                <span
                  v-else
                  class="rounded-full bg-yellow-100 px-3 py-1 text-xs text-yellow-700"
                >
                  Pending
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </AppLayout>
</template>
