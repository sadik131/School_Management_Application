<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link, router } from '@inertiajs/vue3'

const breadcrumbs = [
    {
        title: 'Courses',
        href: dashboard().url,
    },
]

defineProps({
    courses: Array
})

const handleDelete = (id) => {
    if (confirm('Are you sure you want to delete this course?')) {
        router.delete(`/courses/${id}`)
    }
}
</script>

<template>
    <Head title="Courses" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

            <!-- Create Button -->
            <div>
                <Link
                    href="/courses/create"
                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700"
                >
                    Create Course
                </Link>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Code</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="course in courses"
                            :key="course.id"
                            class="hover:bg-gray-50 transition"
                        >
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ course.id }}
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                {{ course.name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ course.code ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-sm">
                                <span
                                    :class="course.status
                                        ? 'bg-green-500 text-white'
                                        : 'bg-gray-400 text-white'"
                                    class="px-2 py-1 rounded text-xs"
                                >
                                    {{ course.status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center space-x-2">
                                <Link
                                    :href="`/courses/${course.id}/edit`"
                                    class="px-3 py-1 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700"
                                >
                                    Edit
                                </Link>

                                <button
                                    @click="handleDelete(course.id)"
                                    class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>

                        <tr v-if="!courses.length">
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No courses found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
