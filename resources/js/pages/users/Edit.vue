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
  status: true,
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

  /* ================= STUDENT AUTO SELECT ================= */
  if (props.user.student?.section_id) {
    const sec = props.sections.find(
      s => s.id === props.user.student.section_id
    )

    if (sec) {
      studentCourse.value = sec.semester.course.name
      studentSemester.value = sec.semester.name
      studentForm.section_id = sec.id
    }
  }

  /* ================= TEACHER AUTO SELECT ================= */
  if (props.user.teacher?.sections?.length) {
    const first = props.user.teacher.sections[0]
    const sec = props.sections.find(s => s.id === first.id)

    if (sec) {
      teacherCourse.value = sec.semester.course.name
      teacherSemester.value = sec.semester.name
      teacherForm.sections = props.user.teacher.sections.map(s => s.id)
    }
  }

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
    <div class="mx-auto max-w-4xl  w-full space-y-6 p-6">
      <Link href="/users" class="inline-block rounded bg-indigo-600 px-4 py-2 text-sm text-white">
        ← Back
      </Link>
      <!-- ================= USER ================= -->
      <div class="rounded-xl bg-white p-6 shadow">
        <h2 class="mb-4 text-xl font-semibold">Edit User</h2>
        <form @submit.prevent="submitUser" class="space-y-4">

          <!-- Name -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Name
            </label>
            <input v-model="userForm.name" type="text" placeholder="Enter full name"
              class="w-full rounded border px-4 py-2" />
            <p v-if="userForm.errors.name" class="mt-1 text-sm text-red-500">
              {{ userForm.errors.name }}
            </p>
          </div>

          <!-- Email -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Email
            </label>
            <input v-model="userForm.email" type="email" placeholder="Enter email address"
              class="w-full rounded border px-4 py-2" />
            <p v-if="userForm.errors.email" class="mt-1 text-sm text-red-500">
              {{ userForm.errors.email }}
            </p>
          </div>

          <!-- Password -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Password
            </label>
            <input v-model="userForm.password" type="password" placeholder="Leave blank to keep current password"
              class="w-full rounded border px-4 py-2" />
            <p v-if="userForm.errors.password" class="mt-1 text-sm text-red-500">
              {{ userForm.errors.password }}
            </p>
          </div>

          <!-- Status -->
          <div class="flex items-center gap-2">
            <input id="userStatus" v-model="userForm.status" type="checkbox"
              class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
            <label for="userStatus" class="text-sm font-medium text-gray-700">
              Active User
            </label>
          </div>

          <!-- Role -->
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-700">
              Roles
            </label>

            <div class="grid grid-cols-2 gap-2">
              <label v-for="role in roles" :key="role.id" class="flex items-center gap-2 rounded border p-2 text-sm">
                <input type="checkbox" :value="role.name" v-model="userForm.role"
                  class="rounded border-gray-300 text-indigo-600" />
                <span class="capitalize">{{ role.name }}</span>
              </label>
            </div>

            <p v-if="userForm.errors.role" class="mt-1 text-sm text-red-500">
              {{ userForm.errors.role }}
            </p>
          </div>

          <!-- Submit -->
          <button type="submit" class="w-full rounded bg-indigo-600 py-2 text-white hover:bg-indigo-700">
            Save User
          </button>

        </form>

      </div>

      <!-- ================= STUDENT ================= -->
      <div v-if="isStudent" class="rounded-xl bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold">Student Information</h3>

        <div class="space-y-4">

          <!-- Student ID -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Student ID
            </label>
            <input v-model="studentForm.student_id" type="text" placeholder="Enter student ID"
              class="w-full rounded border px-4 py-2" />
            <p v-if="studentForm.errors.student_id" class="mt-1 text-sm text-red-500">
              {{ studentForm.errors.student_id }}
            </p>
          </div>

          <!-- Roll Number -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Roll Number
            </label>
            <input v-model="studentForm.roll_number" type="number" placeholder="Enter roll number"
              class="w-full rounded border px-4 py-2" />
            <p v-if="studentForm.errors.roll_number" class="mt-1 text-sm text-red-500">
              {{ studentForm.errors.roll_number }}
            </p>
          </div>

          <!-- Admission Year -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Admission Year
            </label>
            <input v-model="studentForm.admission_year" type="number" placeholder="e.g. 2024"
              class="w-full rounded border px-4 py-2" />
            <p v-if="studentForm.errors.admission_year" class="mt-1 text-sm text-red-500">
              {{ studentForm.errors.admission_year }}
            </p>
          </div>

          <!-- Course -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Course
            </label>
            <select v-model="studentCourse" class="w-full rounded border px-4 py-2">
              <option value="">Select Course</option>
              <option v-for="c in studentCourses" :key="c" :value="c">
                {{ c }}
              </option>
            </select>
          </div>

          <!-- Semester -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Semester
            </label>
            <select v-model="studentSemester" class="w-full rounded border px-4 py-2" :disabled="!studentCourse">
              <option value="">Select Semester</option>
              <option v-for="s in studentSemesters" :key="s" :value="s">
                {{ s }}
              </option>
            </select>
          </div>

          <!-- Section -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Section
            </label>
            <select v-model="studentForm.section_id" class="w-full rounded border px-4 py-2"
              :disabled="!studentSemester">
              <option value="">Select Section</option>
              <option v-for="sec in studentSections" :key="sec.id" :value="sec.id">
                Section {{ sec.name }}
              </option>
            </select>
            <p v-if="studentForm.errors.section_id" class="mt-1 text-sm text-red-500">
              {{ studentForm.errors.section_id }}
            </p>
          </div>

          <!-- Submit -->
          <button type="button" @click.prevent="submitStudent"
            class="w-full rounded bg-green-600 py-2 text-white hover:bg-green-700">
            Save Student Info
          </button>

        </div>

      </div>

      <!-- ================= TEACHER ================= -->
      <div v-if="isTeacher" class="rounded-xl bg-white p-6 shadow">
        <h3 class="mb-4 text-lg font-semibold">Teacher Information</h3>

        <div class="space-y-4">

          <!-- Teacher ID -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Teacher ID
            </label>
            <input type="number" v-model="teacherForm.teacher_id" placeholder="Enter teacher ID"
              class="w-full rounded border px-4 py-2" />
            <p v-if="teacherForm.errors.teacher_id" class="mt-1 text-sm text-red-500">
              {{ teacherForm.errors.teacher_id }}
            </p>
          </div>

          <!-- Department -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Department
            </label>
            <input v-model="teacherForm.department" placeholder="e.g. Computer Science"
              class="w-full rounded border px-4 py-2" />
            <p v-if="teacherForm.errors.department" class="mt-1 text-sm text-red-500">
              {{ teacherForm.errors.department }}
            </p>
          </div>

          <!-- Designation -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Designation
            </label>
            <input v-model="teacherForm.designation" placeholder="e.g. Assistant Professor"
              class="w-full rounded border px-4 py-2" />
            <p v-if="teacherForm.errors.designation" class="mt-1 text-sm text-red-500">
              {{ teacherForm.errors.designation }}
            </p>
          </div>

          <!-- Qualification -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Qualification
            </label>
            <input v-model="teacherForm.qualification" placeholder="e.g. M.Sc, PhD"
              class="w-full rounded border px-4 py-2" />
            <p v-if="teacherForm.errors.qualification" class="mt-1 text-sm text-red-500">
              {{ teacherForm.errors.qualification }}
            </p>
          </div>

          <!-- Experience -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Experience (Years)
            </label>
            <input v-model="teacherForm.experience" placeholder="e.g. 5" class="w-full rounded border px-4 py-2" />
            <p v-if="teacherForm.errors.experience" class="mt-1 text-sm text-red-500">
              {{ teacherForm.errors.experience }}
            </p>
          </div>

          <!-- Course -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Course
            </label>
            <select v-model="teacherCourse" class="w-full rounded border px-4 py-2">
              <option value="">Select Course</option>
              <option v-for="c in teacherCourses" :key="c" :value="c">
                {{ c }}
              </option>
            </select>
          </div>

          <!-- Semester -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Semester
            </label>
            <select v-model="teacherSemester" class="w-full rounded border px-4 py-2" :disabled="!teacherCourse">
              <option value="">Select Semester</option>
              <option v-for="s in teacherSemesters" :key="s" :value="s">
                {{ s }}
              </option>
            </select>
          </div>

          <!-- Sections -->
          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">
              Sections (Multiple)
            </label>

            <div v-if="teacherSemester" class="max-h-48 space-y-2 overflow-y-auto rounded border p-3">
              <label v-for="sec in teacherSections" :key="sec.id" class="flex items-center gap-2 text-sm">
                <input type="checkbox" :value="sec.id" v-model="teacherForm.sections"
                  class="rounded border-gray-300 text-indigo-600" />
                <span>
                  Section {{ sec.name }}
                </span>
              </label>
            </div>

            <p v-else class="text-xs text-gray-500">
              Select Course & Semester to see sections
            </p>

            <p v-if="teacherForm.errors.sections" class="mt-1 text-sm text-red-500">
              {{ teacherForm.errors.sections }}
            </p>
          </div>

          <!-- Submit -->
          <button type="button" @click.prevent="submitTeacher"
            class="w-full rounded bg-blue-600 py-2 text-white hover:bg-blue-700">
            Save Teacher Info
          </button>

        </div>

      </div>

    </div>
  </AppLayout>
</template>
