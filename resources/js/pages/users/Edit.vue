<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { ref, computed, watch, onMounted } from 'vue'

/* ================= PROPS ================= */
const props = defineProps({
  user: Object,
  roles: Array,
  sections: Array,
})

/* ================= USER FORM ================= */
const userForm = useForm({
  name: props.user.name,
  email: props.user.email,
  password: '',
  role: props.user.roles.map(r => r.name),
})

const submitUser = () => {
  router.put(`/users/${props.user.id}`, userForm)
}

/* ================= ROLE CHECK ================= */
const isTeacher = computed(() => userForm.role.includes('teacher'))
const isStudent = computed(() => userForm.role.includes('student'))

/* =========================================================
   ======================= STUDENT =========================
   ========================================================= */

const studentCourse = ref('')
const studentSemester = ref('')

const studentForm = useForm({
  student_id: props.user.student?.student_id ?? '',
  admission_year: props.user.student?.admission_year ?? '',
  section_id: props.user.student?.section_id ?? '',
  roll_number: props.user.student?.roll_number ?? '',
})

const studentCourses = computed(() => {
  return [...new Set(
    props.sections.map(sec => sec.semester.course.name)
  )]
})

const studentSemesters = computed(() => {
  if (!studentCourse.value) return []

  return [...new Set(
    props.sections
      .filter(sec => sec.semester.course.name === studentCourse.value)
      .map(sec => sec.semester.name)
  )]
})

const studentSections = computed(() => {
  if (!studentCourse.value || !studentSemester.value) return []

  return props.sections.filter(sec =>
    sec.semester.course.name === studentCourse.value &&
    sec.semester.name === studentSemester.value
  )
})

const submitStudent = () => {
  router.post(`/users/${props.user.id}/student`, studentForm, {
    preserveScroll: true,
  })
}

onMounted(() => {
  if (!props.user.teacher?.sections?.length) return

  const first = props.user.teacher.sections[0]
  const sec = props.sections.find(s => s.id === first.id)
  if (!sec) return

  teacherCourse.value = sec.semester.course.name
  teacherSemester.value = sec.semester.name

  teacherForm.sections = props.user.teacher.sections.map(s => s.id)
})


/* =========================================================
   ======================= TEACHER =========================
   ========================================================= */

const teacherCourse = ref('')
const teacherSemester = ref('')

const teacherForm = useForm({
  teacher_id: props.user.teacher?.teacher_id ?? '',
  department: props.user.teacher?.department ?? '',
  designation: props.user.teacher?.designation ?? '',
  qualification: props.user.teacher?.qualification ?? '',
  experience: props.user.teacher?.experience ?? '',
  sections: props.user.teacher
    ? props.user.teacher.sections.map(s => s.id)
    : [],
})

const teacherCourses = computed(() => {
  return [...new Set(
    props.sections.map(sec => sec.semester.course.name)
  )]
})

const teacherSemesters = computed(() => {
  if (!teacherCourse.value) return []

  return [...new Set(
    props.sections
      .filter(sec => sec.semester.course.name === teacherCourse.value)
      .map(sec => sec.semester.name)
  )]
})

const teacherSections = computed(() => {
  if (!teacherCourse.value || !teacherSemester.value) return []

  return props.sections.filter(sec =>
    sec.semester.course.name === teacherCourse.value &&
    sec.semester.name === teacherSemester.value
  )
})

watch(teacherCourse, (newVal, oldVal) => {
  if (oldVal) {
    teacherSemester.value = ''
    teacherForm.sections = []
  }
})

watch(teacherSemester, (newVal, oldVal) => {
  if (oldVal) {
    teacherForm.sections = []
  }
})


const submitTeacher = () => {
  router.post(`/users/${props.user.id}/teacher`, teacherForm, {
    preserveScroll: true,
  })
}

/* auto select on edit (teacher) */
onMounted(() => {
  if (!props.user.teacher?.sections?.length) return

  const first = props.user.teacher.sections[0]
  const sec = props.sections.find(s => s.id === first.id)
  if (!sec) return

  teacherCourse.value = sec.semester.course.name
  teacherSemester.value = sec.semester.name
})
</script>


<template>

  <Head title="Edit User" />

  <AppLayout>
    <div class="mx-auto max-w-4xl space-y-6 p-6">
      <Link href="/users" class="inline-block rounded bg-indigo-600 px-4 py-2 text-sm text-white">
        ← Back
      </Link>
      <!-- ================= USER ================= -->
      <div class="rounded-xl bg-white p-6 shadow">
        <h2 class="mb-4 text-xl font-semibold">Edit User</h2>

        <form @submit.prevent="submitUser" class="space-y-4">
          <input v-model="userForm.name" placeholder="Name" class="w-full rounded border px-4 py-2" />
          <input v-model="userForm.email" placeholder="Email" class="w-full rounded border px-4 py-2" />
          <input v-model="userForm.password" type="password" placeholder="Password"
            class="w-full rounded border px-4 py-2" />

          <div class="grid grid-cols-2 gap-2">
            <label v-for="role in roles" :key="role.id" class="flex items-center gap-2 rounded border p-2">
              <input type="checkbox" :value="role.name" v-model="userForm.role" />
              <span class="capitalize">{{ role.name }}</span>
            </label>
          </div>

          <button class="w-full rounded bg-indigo-600 py-2 text-white">
            Save User
          </button>
        </form>
      </div>

      <!-- ================= STUDENT ================= -->
      <div v-if="isStudent" class="rounded-xl bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold">Student Information</h3>

        <div class="space-y-4">
          <input v-model="studentForm.student_id" placeholder="Student ID" class="w-full rounded border px-4 py-2" />

          <input type="number" v-model="studentForm.roll_number" class="w-full rounded border px-4 py-2"
            placeholder="Roll Number" />

          <input v-model="studentForm.admission_year" type="number" placeholder="Admission Year"
            class="w-full rounded border px-4 py-2" />

          <select v-model="studentCourse" class="w-full rounded border px-4 py-2">
            <option value="">Select Course</option>
            <option v-for="c in studentCourses" :key="c" :value="c">{{ c }}</option>
          </select>

          <select v-model="studentSemester" class="w-full rounded border px-4 py-2" :disabled="!studentCourse">
            <option value="">Select Semester</option>
            <option v-for="s in studentSemesters" :key="s" :value="s">{{ s }}</option>
          </select>

          <select v-model="studentForm.section_id" class="w-full rounded border px-4 py-2" :disabled="!studentSemester">
            <option value="">Select Section</option>
            <option v-for="sec in studentSections" :key="sec.id" :value="sec.id">
              Section {{ sec.name }}
            </option>
          </select>

          <button @click="submitStudent" class="w-full rounded bg-green-600 py-2 text-white">
            Save Student Info
          </button>
        </div>
      </div>

      <!-- ================= TEACHER ================= -->
      <div v-if="isTeacher" class="rounded-xl bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold">Teacher Information</h3>

        <div class="space-y-4">
          <input type="number" v-model="teacherForm.teacher_id" placeholder="Teacher ID" class="w-full rounded border px-4 py-2" />
          <input v-model="teacherForm.department" placeholder="Department" class="w-full rounded border px-4 py-2" />

          <input v-model="teacherForm.designation" placeholder="Designation" class="w-full rounded border px-4 py-2" />

          <input v-model="teacherForm.qualification" placeholder="Qualification"
            class="w-full rounded border px-4 py-2" />

          <input v-model="teacherForm.experience" placeholder="Experience" class="w-full rounded border px-4 py-2" />

          <select v-model="teacherCourse" class="w-full rounded border px-4 py-2">
            <option value="">Select Course</option>
            <option v-for="c in teacherCourses" :key="c" :value="c">{{ c }}</option>
          </select>

          <select v-model="teacherSemester" class="w-full rounded border px-4 py-2" :disabled="!teacherCourse">
            <option value="">Select Semester</option>
            <option v-for="s in teacherSemesters" :key="s" :value="s">{{ s }}</option>
          </select>

          <div>
            <label class="mb-1 block text-sm font-medium">
              Sections (Multiple)
            </label>

            <div v-if="teacherSemester" class="max-h-48 space-y-2 overflow-y-auto rounded border p-3">
              <label v-for="sec in teacherSections" :key="sec.id" class="flex items-center gap-2 text-sm">
                <input type="checkbox" :value="sec.id" v-model="teacherForm.sections" class="rounded border" />
                <span>
                  Section {{ sec.name }}
                </span>
              </label>
            </div>

            <p v-else class="text-xs text-gray-500">
              Select Course & Semester to see sections
            </p>
          </div>

          <button @click="submitTeacher" class="w-full rounded bg-blue-600 py-2 text-white">
            Save Teacher Info
          </button>
        </div>
      </div>

    </div>
  </AppLayout>
</template>
