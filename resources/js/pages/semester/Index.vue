<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link, router } from '@inertiajs/vue3'

const breadcrumbs = [
    {
        title: 'Semesters',
        href: dashboard().url,
    },
]

defineProps({
    semesters: Array
})

const handleDelete = (id) => {
    if (confirm('Are you sure you want to delete this semester?')) {
        router.delete(`/semesters/${id}`)
    }
}
</script>

<template>
    <Head title="Semesters" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

            <!-- Create Button -->
            <div>
                <Link
                    href="/semesters/create"
                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700"
                >
                    Create Semester
                </Link>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Course</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Semester</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Sem Number</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="semester in semesters"
                            :key="semester.id"
                            class="hover:bg-gray-50 transition"
                        >
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ semester.id }}
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ semester.course.name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ semester.name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ semester.number }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                <span
                                    :class="semester.status
                                        ? 'bg-green-500 text-white'
                                        : 'bg-gray-400 text-white'"
                                    class="px-2 py-1 rounded text-xs"
                                >
                                    {{ semester.status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center space-x-2">
                                <Link
                                    :href="`/semesters/${semester.id}/edit`"
                                    class="px-3 py-1 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700"
                                >
                                    Edit
                                </Link>

                                <button
                                    @click="handleDelete(semester.id)"
                                    class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <tr v-if="!semesters.length">
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No semesters found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </AppLayout>
</template>
