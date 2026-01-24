<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link, router } from '@inertiajs/vue3'

const breadcrumbs = [
    { title: 'Sections', href: dashboard().url }
]

defineProps({
    sections: Array
})

const handleDelete = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(`/sections/${id}`)
    }
}
</script>

<template>
    <Head title="Sections" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

            <div>
                <Link
                    href="/sections/create"
                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700"
                >
                    Create Section
                </Link>
            </div>

            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
    <tr>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">ID</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Course</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Semester</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Section</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Capacity</th>
        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Action</th>
    </tr>
</thead>

<tbody class="divide-y divide-gray-200">
    <tr
        v-for="section in sections"
        :key="section.id"
        class="hover:bg-gray-50 transition"
    >
        <td class="px-6 py-4 text-sm text-gray-700">
            {{ section.id }}
        </td>

        <td class="px-6 py-4 text-sm font-medium text-gray-900">
            {{ section.semester.course.name }}
        </td>

        <td class="px-6 py-4 text-sm text-gray-700">
            {{ section.semester.name }}
        </td>

        <td class="px-6 py-4 text-sm font-medium text-gray-900">
            {{ section.name }}
        </td>

        <td class="px-6 py-4 text-sm text-gray-700">
            {{ section.capacity ?? '-' }}
        </td>

        <td class="px-6 py-4 text-sm">
            <span
                :class="section.status
                    ? 'bg-green-500 text-white'
                    : 'bg-gray-400 text-white'"
                class="px-2 py-1 rounded text-xs"
            >
                {{ section.status ? 'Active' : 'Inactive' }}
            </span>
        </td>

        <td class="px-6 py-4 text-center space-x-2">
            <Link
                :href="`/sections/${section.id}/edit`"
                class="px-3 py-1 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700"
            >
                Edit
            </Link>

            <button
                @click="handleDelete(section.id)"
                class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700"
            >
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
