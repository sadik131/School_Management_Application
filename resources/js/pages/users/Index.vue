<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link, router } from '@inertiajs/vue3'
import { reactive, watch, ref } from 'vue'

/* ---------------- Breadcrumbs ---------------- */
const breadcrumbs = [
  {
    title: 'Users page',
    href: dashboard().url,
  },
]

/* ---------------- Props ---------------- */
const props = defineProps({
  users: Object,
  filters: Object,
})

/* ---------------- Filters ---------------- */
const filters = reactive({
  search: props.filters?.search || '',
  role: props.filters?.role || '',
  status: props.filters?.status || '',
})

watch(filters, () => {
  router.get('/users', filters, {
    preserveState: true,
    replace: true,
  })
})

const resetFilters = () => {
  filters.search = ''
  filters.role = ''
  filters.status = ''
}

/* ---------------- Delete ---------------- */
const handleDelete = (id) => {
  if (confirm('Are you sure?')) {
    router.delete(`/users/${id}`)
  }
}



/* ---------------- Modal State ---------------- */
const showDetailsModal = ref(false)
const selectedUser = ref(null)

const viewDetails = (user) => {
  selectedUser.value = user
  showDetailsModal.value = true
}

const closeModal = () => {
  showDetailsModal.value = false
  selectedUser.value = null
}

</script>

<template>

  <Head title="Users" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4 rounded-xl p-4">

      <!-- Create -->
      <div>
        <Link href="/users/create" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
          Create User
        </Link>
      </div>
      <!-- Filters -->
      <div class="bg-white p-4 rounded-xl shadow flex flex-wrap gap-3 items-center">
        <input v-model="filters.search" type="text" placeholder="Search name or email..."
          class="border rounded px-3 py-2 text-sm w-56" />

        <select v-model="filters.role" class="border rounded px-3 py-2 text-sm">
          <option value="">All Roles</option>
          <option value="admin">Admin</option>
          <option value="teacher">Teacher</option>
          <option value="student">Student</option>
        </select>

        <select v-model="filters.status" class="border rounded px-3 py-2 text-sm">
          <option value="">All Status</option>
          <option value="active">Active</option>
          <option value="blocked">Blocked</option>
        </select>

        <button @click="resetFilters" class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
          Reset
        </button>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto bg-white rounded-xl shadow">
        <table class="min-w-full border border-gray-200">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Role</th>
              <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
              <th class="px-6 py-3 text-center text-sm font-semibold">Action</th>
            </tr>
          </thead>

          <tbody class="divide-y">
            <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm">{{ user.id }}</td>
              <td class="px-6 py-4 text-sm font-medium">{{ user.name }}</td>
              <td class="px-6 py-4 text-sm text-gray-600">{{ user.email }}</td>
              <td class="px-6 py-4">
                <template v-if="user.roles && user.roles.length">
                  <span v-for="role in user.roles" :key="role.id" class="px-3 py-1 mr-1 text-xs rounded-full" :class="{
                    'bg-red-100 text-red-700': role.name === 'admin',
                    'bg-green-100 text-green-700': role.name === 'teacher',
                    'bg-blue-100 text-blue-700': role.name === 'student'
                  }">
                    {{ role.name }}
                  </span>
                </template>

                <span v-else class="text-gray-400 text-xs">
                  No Role
                </span>
              </td>


              <td class="px-6 py-4">
                <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                  Active
                </span>
              </td>

              <td class="px-6 py-4 text-center space-x-2">
                <button @click="viewDetails(user)"
                  class="px-3 py-1 text-sm text-white bg-gray-600 rounded hover:bg-gray-700">
                  View
                </button>

                <Link :href="`/users/${user.id}/edit`"
                  class="px-3 py-1 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
                  Edit
                </Link>

                <button @click="handleDelete(user.id)"
                  class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- ================= USER DETAILS MODAL ================= -->
      <div v-if="showDetailsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-xl max-h-[90vh] flex flex-col">

          <!-- Header -->
          <div class="flex items-center justify-between px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">
              {{ selectedUser?.student ? 'Student Information'
                : selectedUser?.teacher ? 'Teacher Information'
                  : 'User Information' }}
            </h3>
            <button @click="closeModal" class="text-gray-400 hover:text-gray-600 text-xl leading-none">
              ×
            </button>
          </div>

          <!-- Body -->
          <div class="flex-1 overflow-y-auto px-6 py-5 space-y-6 text-sm text-gray-700">

            <!-- BASIC INFO -->
            <div class="bg-gray-50 rounded-xl p-4 space-y-1">
              <h4 class="font-semibold text-gray-800 mb-2">Basic Information</h4>

              <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div><span class="text-gray-500">Name:</span> {{ selectedUser?.name ?? 'Not set' }}</div>
                <div><span class="text-gray-500">Email:</span> {{ selectedUser?.email ?? 'Not set' }}</div>
                <div><span class="text-gray-500">Phone:</span> {{ selectedUser?.phone ?? 'Not set' }}</div>
                <div><span class="text-gray-500">Gender:</span> {{ selectedUser?.gender ?? 'Not set' }}</div>
                <div><span class="text-gray-500">DOB:</span> {{ selectedUser?.dob ?? 'Not set' }}</div>
                <div><span class="text-gray-500">Blood:</span> {{ selectedUser?.blood ?? 'Not set' }}</div>
              </div>

              <div class="pt-2">
                <span class="text-gray-500">Address:</span>
                {{ selectedUser?.address ?? 'Not set' }}
              </div>
            </div>

            <!-- STUDENT ACADEMIC -->
            <div v-if="selectedUser?.student" class="bg-gray-50 rounded-xl p-4 space-y-1">
              <h4 class="font-semibold text-gray-800 mb-2">Academic Information</h4>
              <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div><span class="text-gray-500">Student ID:</span> {{ selectedUser.student.student_id ?? 'Not set' }}
                </div>
                <div><span class="text-gray-500">Course:</span> {{ selectedUser.student.program ?? 'Not set' }}</div>
                <div><span class="text-gray-500">Section:</span> {{ selectedUser.student.section.name ?? 'Not set' }}
                </div>
                <div><span class="text-gray-500">Semester:</span> {{ selectedUser.student.semester ?? 'Not set' }}</div>
                <div class="col-span-2">
                  <span class="text-gray-500">Roll No:</span>
                  {{ selectedUser.student.roll_number ?? 'Not set' }}
                </div>
              </div>
            </div>

            <!-- ================= TEACHER ACADEMIC ================= -->
            <div v-if="selectedUser?.teacher" class="bg-gray-50 rounded-xl p-4 space-y-3">

              <h4 class="font-semibold text-gray-800">Professional Information</h4>

              <!-- Basic Info -->
              <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                <div>
                  <span class="text-gray-500">Teacher ID:</span>
                  {{ selectedUser.teacher.teacher_id ?? 'Not set' }}
                </div>

                <div>
                  <span class="text-gray-500">Department:</span>
                  {{ selectedUser.teacher.department ?? 'Not set' }}
                </div>

                <div>
                  <span class="text-gray-500">Designation:</span>
                  {{ selectedUser.teacher.designation ?? 'Not set' }}
                </div>

                <div>
                  <span class="text-gray-500">Experience:</span>
                  {{ selectedUser.teacher.experience ?? 'Not set' }}
                </div>
              </div>

              <!-- Assigned Classes -->
              <div v-if="selectedUser.teacher.sections?.length">
                <h5 class="font-medium text-gray-700 mt-3 mb-1">
                  Assigned Classes
                </h5>

                <div class="space-y-2 text-sm">
                  <div v-for="(group, index) in selectedUser.teacher.sections" :key="index"
                    class="pl-2 border-l-2 border-indigo-200">
                    <div class="text-gray-600 ml-2">
                      {{ group.semester.course.name }} ·
                      {{ group.semester.name }} ·
                      section {{ group.name }}
                    </div>
                  </div>
                </div>
              </div>

              <div v-else class="text-sm text-gray-500">
                No sections assigned
              </div>

            </div>


            <!-- ACTIVITY -->
            <div v-if="selectedUser?.student?.activity || selectedUser?.teacher?.activity"
              class="bg-gray-50 rounded-xl p-4 space-y-2">
              <h4 class="font-semibold text-gray-800 mb-2">Activity Summary</h4>

              <!-- Student activity -->
              <template v-if="selectedUser?.student?.activity">
                <div class="flex justify-between">
                  <span class="text-gray-500">Attendance</span>
                  <span class="font-medium">
                    {{ selectedUser.student.activity.attendance_percentage ?? 'Not set' }}
                    ({{ selectedUser.student.activity.classes_attended ?? '0' }}/{{
                      selectedUser.student.activity.total_classes ?? '0' }})
                  </span>
                </div>

                <div class="flex justify-between">
                  <span class="text-gray-500">Assignments</span>
                  <span class="font-medium">
                    {{ selectedUser.student.activity.assignments_submitted ?? '0' }} Submitted,
                    {{ selectedUser.student.activity.assignments_pending ?? '0' }} Pending
                  </span>
                </div>
              </template>

              <!-- Teacher activity -->
              <template v-if="selectedUser?.teacher?.activity">
                <div class="flex justify-between">
                  <span class="text-gray-500">Total Classes</span>
                  <span class="font-medium">
                    {{ selectedUser.teacher.activity.total_classes ?? 'Not set' }}
                  </span>
                </div>

                <div class="flex justify-between">
                  <span class="text-gray-500">Assignments</span>
                  <span class="font-medium">
                    {{ selectedUser.teacher.activity.total_assignments ?? '0' }} Total,
                    {{ selectedUser.teacher.activity.pending_assignments ?? '0' }} Pending
                  </span>
                </div>
              </template>
            </div>

            <!-- NO PROFILE -->
            <div v-if="!selectedUser?.student && !selectedUser?.teacher" class="text-center text-red-600 text-sm">
              No academic / professional profile linked with this user.
            </div>

          </div>

          <!-- Footer -->
          <div class="px-6 py-4 border-t flex justify-end">
            <button @click="closeModal"
              class="px-5 py-2 text-sm bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
              Close
            </button>
          </div>

        </div>
      </div>




    </div>
  </AppLayout>
</template>
