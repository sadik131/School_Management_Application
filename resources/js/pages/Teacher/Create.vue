<script setup>
import { ref, computed } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, router } from '@inertiajs/vue3'

const props = defineProps({
  sections: Array,
})

const form = ref({
  course: '',
  semester: '',
  section_id: '',
  title: '',
  description: '',
  due_date: '',
})

/* group by course → semester */
const grouped = computed(() => {
  const map = {}

  props.sections.forEach((s) => {
    const c = s.semester.course.name
    const sem = s.semester.name

    map[c] ??= {}
    map[c][sem] ??= []
    map[c][sem].push(s)
  })

  return map
})

const semesters = computed(() =>
  form.value.course ? Object.keys(grouped.value[form.value.course]) : []
)

const sections = computed(() =>
  form.value.semester
    ? grouped.value[form.value.course][form.value.semester]
    : []
)

const submit = () => {
  router.post('/teacher/assignments', form.value)
}
</script>

<template>
  <Head title="Create Assignment" />

  <AppLayout>
    <div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow">

      <h2 class="mb-6 text-lg font-semibold">
        Create Assignment
      </h2>

      <div class="space-y-4">

        <!-- Course -->
        <select v-model="form.course" class="w-full rounded border p-2">
          <option value="">Select Course</option>
          <option v-for="(v, k) in grouped" :key="k">
            {{ k }}
          </option>
        </select>

        <!-- Semester -->
        <select v-model="form.semester" class="w-full rounded border p-2">
          <option value="">Select Semester</option>
          <option v-for="s in semesters" :key="s">{{ s }}</option>
        </select>

        <!-- Section -->
        <select v-model="form.section_id" class="w-full rounded border p-2">
          <option value="">Select Section</option>
          <option
            v-for="s in sections"
            :key="s.id"
            :value="s.id"
          >
            Section {{ s.name }}
          </option>
        </select>

        <input v-model="form.title" placeholder="Assignment title" class="w-full rounded border p-2" />
        <textarea v-model="form.description" placeholder="Description" class="w-full rounded border p-2"></textarea>
        <input v-model="form.due_date" type="date" class="w-full rounded border p-2" />

        <button
          @click="submit"
          class="w-full rounded bg-indigo-600 py-2 text-white"
        >
          Create Assignment
        </button>
      </div>
    </div>
  </AppLayout>
</template>
