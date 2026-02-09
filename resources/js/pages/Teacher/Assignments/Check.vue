<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const props = defineProps({
  assignment: Object,
  submissions: Array,
})

const showModal = ref(false)
const activeSubmission = ref(null)

const form = useForm({
  submission_id: null,
  marks: null,
})

const openModal = (submission) => {
  activeSubmission.value = submission
  form.submission_id = submission.id
  form.marks = submission.marks
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  activeSubmission.value = null
}

const saveMarks = () => {
  form.post(`/teacher/assignments/${props.assignment.id}/marks`, {
    onSuccess: () => closeModal(),
  })
}
</script>

<template>
  <AppLayout>

    <Head title="Check Assignments" />
    
    <div class="max-w-4xl w-full mx-auto p-6 bg-white rounded shadow space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
      <h2 class="text-lg font-semibold">
        Checking: {{ assignment.title }}
      </h2>
      
      <!-- Back button -->
      <Link
        href="/teacher/ass"
        class="text-sm text-gray-600 hover:underline"
      >
        ← Back
      </Link>
    </div>

    <!-- Table -->
    <table class="w-full text-sm border">
      <thead class="bg-gray-50">
        <tr>
          <th class="p-2 text-left">Student</th>
          <th class="p-2 text-center">Roll</th>
          <th class="p-2 text-center">Marks</th>
          <th class="p-2 text-right">Action</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="s in submissions"
          :key="s.id"
          class="border-t hover:bg-gray-50"
        >
          <td class="p-2">{{ s.student_name }}</td>
          <td class="p-2 text-center">{{ s.roll }}</td>

          <td class="p-2 text-center">
            <span v-if="s.marks !== null" class="text-green-700 font-semibold">
              {{ s.marks }}
            </span>
            <span v-else class="text-gray-400 text-xs">—</span>
          </td>

          <td class="p-2 text-right">
            <button
              @click="openModal(s)"
              class="text-indigo-600 hover:underline text-sm"
            >
              Check
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- ================= MODAL ================= -->
  <div
    v-if="showModal"
    class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
  >
    <div class="bg-white w-full max-w-xl rounded-xl p-6 space-y-4">

      <div class="flex justify-between items-center">
        <h3 class="font-semibold text-lg">
          {{ activeSubmission.student_name }}
        </h3>

        <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
          ✕
        </button>
      </div>

      <!-- Answer -->
      <div>
        <p class="text-sm text-gray-500 mb-1">Answer</p>
        <div class="border rounded p-3 text-sm bg-gray-50 whitespace-pre-wrap">
          {{ activeSubmission.answer_text }}
        </div>
      </div>

      <!-- Marks -->
      <div>
        <label class="text-sm text-gray-500">Marks</label>
        <input
          type="number"
          min="0"
          v-model="form.marks"
          class="mt-1 block w-24 border rounded px-2 py-1"
        />
      </div>

      <!-- Actions -->
      <div class="flex justify-end gap-2">
        <button
          @click="closeModal"
          class="px-4 py-2 text-sm border rounded"
        >
          Cancel
        </button>

        <button
        @click="saveMarks"
        class="px-4 py-2 text-sm bg-indigo-600 text-white rounded"
        :disabled="form.processing"
        >
          Save
        </button>
      </div>

    </div>
  </div>
</AppLayout>
</template>
