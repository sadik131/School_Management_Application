<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link, router } from '@inertiajs/vue3'

const breadcrumbs = [
  { title: 'Permissions', href: dashboard().url }
]

defineProps({
  permissions: Array
})


const handleDelete = (id) => {
  if (confirm('Are you sure you want to delete this permission?')) {
    router.delete(`/permission/${id}`)
  }
}
</script>

<template>

  <Head title="Permissions" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-col gap-4 p-4">
      <!-- Create Permission -->
      <div>
        <Link href="/permission/create" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
          Create Permission
        </Link>
      </div>

      <!-- Permission Table -->
      <div class="overflow-x-auto bg-white rounded-xl shadow-md">
        <table class="min-w-full border border-gray-200">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                ID
              </th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                Permission Name
              </th>
              <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">
                Action
              </th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            <tr v-for="p in permissions" :key="p.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm text-gray-700">
                {{ p.id }}
              </td>

              <td class="px-6 py-4 text-sm font-medium text-gray-900">
                {{ p.name }}
              </td>

              <td class="px-6 py-4 flex gap-1 text-center">
                <Link :href="`/roles/${p.id}/edit`"
                  class="px-3 py-1 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
                  Edit
                </Link>
                <button @click="handleDelete(p.id)"
                  class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </AppLayout>
</template>
