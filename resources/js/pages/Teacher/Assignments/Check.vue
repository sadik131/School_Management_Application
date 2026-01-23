<script setup lang="ts">
import { ref } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head } from '@inertiajs/vue3'

const groupName = 'Class 10-A Science'

const submissions = ref([
  { id: 1, student: 'Rahim', status: 'Pending', marks: '' },
  { id: 2, student: 'Karim', status: 'Pending', marks: '' },
  { id: 3, student: 'Ayesha', status: 'Checked', marks: 8 },
])

const checkSubmission = (s: any) => {
  s.status = 'Checked'
}
</script>

<template>
  <Head title="Check Assignment" />

  <AppLayout>
    <div class="rounded-xl bg-white p-6 shadow space-y-4">

      <h2 class="text-xl font-semibold">
        Checking Assignment – {{ groupName }}
      </h2>

      <table class="w-full text-sm">
        <thead class="border-b text-gray-500">
          <tr>
            <th>Student</th>
            <th>Status</th>
            <th>Marks</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="s in submissions"
            :key="s.id"
            class="border-b"
          >
            <td>{{ s.student }}</td>

            <td>
              <span
                :class="s.status === 'Checked'
                  ? 'text-green-600'
                  : 'text-orange-500'"
              >
                {{ s.status }}
              </span>
            </td>

            <td>
              <input
                v-model="s.marks"
                type="number"
                class="w-20 rounded border px-2 py-1"
                placeholder="-"
              />
            </td>

            <td>
              <button
                @click="checkSubmission(s)"
                class="rounded bg-blue-600 px-3 py-1 text-white text-sm"
              >
                ✓ Check
              </button>
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </AppLayout>
</template>
