<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const breadcrumbs = [
  { title: 'Edit User', href: dashboard().url },
]

const props = defineProps({
  user: Object,
  roles: Array,
})

/* ===== BASIC USER FORM ===== */
const form = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  role: props.user?.roles?.map(r => r.name) ?? [],
})


const submitUser = () => {
  router.put(`/users/${props.user.id}`, form)
}

/* ===== ROLE CHECK ===== */
const isStudent = computed(() => form.role.includes('student'))
const isTeacher = computed(() => form.role.includes('teacher'))
const isAdmin = computed(() => form.role.includes('admin'))

/* ===== STUDENT FORM ===== */
const studentForm = useForm({
  student_id: props.user.student?.student_id ?? '',
  roll_number: props.user.student?.roll_number ?? '',
  section_id: props.user.student?.section_id ?? '',
  program: props.user.student?.program ?? '',
  semester: props.user.student?.semester ?? '',
  admission_year: props.user.student?.admission_year ?? '',
})

const submitStudent = () => {
  router.post(`/users/${props.user.id}/student`, studentForm)
}

/* ===== TEACHER FORM ===== */
const teacherForm = useForm({
  designation: props.user.teacher?.designation ?? '',
  department: props.user.teacher?.department ?? '',
  joining_date: props.user.teacher?.joining_date ?? '',
  qualification: props.user.teacher?.qualification ?? '',
  experience: props.user.teacher?.experience ?? '',
})

const submitTeacher = () => {
  router.post(`/users/${props.user.id}/teacher`, teacherForm)
}
</script>

<template>
  <Head title="Edit User" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-6 p-4">

      <!-- Back -->
      <Link
        href="/users"
        class="w-fit rounded bg-indigo-600 px-4 py-2 text-sm text-white hover:bg-indigo-700"
        >
        Back
      </Link>
      <!-- ================= USER INFO ================= -->
      <div class="mx-auto w-full max-w-3xl rounded-xl bg-white p-6 shadow">
        <h2 class="mb-6 text-xl font-semibold text-gray-800">Edit User</h2>

        <form @submit.prevent="submitUser" class="space-y-4">
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
            <input
              v-model="form.name"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-500"
            />
          </div>

          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
            <input
              v-model="form.email"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-500"
            />
          </div>

          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Password</label>
            <input
              type="password"
              v-model="form.password"
              class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-indigo-500"
            />
          </div>

          <!-- Roles -->
          <div class="grid grid-cols-2 gap-3">
            <label
              v-for="role in roles"
              :key="role.id"
              class="flex items-center gap-2 rounded border p-2 hover:bg-gray-50"
            >
              <input
                type="checkbox"
                :value="role.name"
                v-model="form.role"
                class="h-4 w-4 text-indigo-600"
              />
              <span class="text-sm capitalize text-gray-700">
                {{ role.name }}
              </span>
            </label>
          </div>

          <button
            class="w-full rounded-lg bg-indigo-600 py-2 text-white hover:bg-indigo-700"
          >
            Save User Info
          </button>
        </form>
      </div>

      <!-- ================= STUDENT INFO ================= -->
      <div
        v-if="isStudent"
        class="mx-auto w-full max-w-3xl rounded-xl bg-white p-6 shadow"
      >
        <h3 class="mb-4 text-lg font-semibold text-gray-800">
          Student Information
        </h3>

        <div class="space-y-3">
          <input v-model="studentForm.student_id" placeholder="Student ID" class="w-full rounded-lg border px-4 py-2" />
          <input v-model="studentForm.roll_number" placeholder="Roll Number" class="w-full rounded-lg border px-4 py-2" />
          <input v-model="studentForm.section_id" placeholder="Section ID" class="w-full rounded-lg border px-4 py-2" />
          <input v-model="studentForm.program" placeholder="Program (BCA/BBA)" class="w-full rounded-lg border px-4 py-2" />
          <input v-model="studentForm.semester" type="number" placeholder="Semester" class="w-full rounded-lg border px-4 py-2" />
          <input v-model="studentForm.admission_year" type="number" placeholder="Admission Year" class="w-full rounded-lg border px-4 py-2" />

          <button
            @click="submitStudent"
            class="w-full rounded-lg bg-green-600 py-2 text-white hover:bg-green-700"
          >
            Save Student Info
          </button>
        </div>
      </div>

      <!-- ================= TEACHER INFO ================= -->
      <div
        v-if="isAdmin || isTeacher"
        class="mx-auto w-full max-w-3xl rounded-xl bg-white p-6 shadow"
      >
        <h3 class="mb-4 text-lg font-semibold text-gray-800">
          Teacher Information
        </h3>

        <div class="space-y-3">
          <input v-model="teacherForm.designation" placeholder="Designation" class="w-full rounded-lg border px-4 py-2" />
          <input v-model="teacherForm.department" placeholder="Department" class="w-full rounded-lg border px-4 py-2" />
          <input v-model="teacherForm.joining_date" type="date" class="w-full rounded-lg border px-4 py-2" />
          <input v-model="teacherForm.qualification" placeholder="Qualification" class="w-full rounded-lg border px-4 py-2" />
          <input v-model="teacherForm.experience" type="number" placeholder="Experience (Years)" class="w-full rounded-lg border px-4 py-2" />

          <button
            @click="submitTeacher"
            class="w-full rounded-lg bg-green-600 py-2 text-white hover:bg-green-700"
          >
            Save Teacher Info
          </button>
        </div>
      </div>

    </div>
  </AppLayout>
</template>
