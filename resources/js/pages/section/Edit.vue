<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link, useForm } from '@inertiajs/vue3'

const breadcrumbs = [
    {
        title: 'Edit Section',
        href: dashboard().url,
    },
]

const props = defineProps({
    section: Object,
    courses: Array,
    semesters: Array,
})

const form = useForm({
    semester_id: props.section.semester_id,
    name: props.section.name,
    capacity: props.section.capacity,
    status: props.section.status,
})

const submit = () => {
    form.put(`/sections/${props.section.id}`)
}
</script>

<template>
    <Head title="Edit Section" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

            <!-- Back -->
            <div>
                <Link
                    href="/sections"
                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700"
                >
                    Back
                </Link>
            </div>

            <div class="max-w-3xl w-full mx-auto bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">
                    Edit Section
                </h2>

                <form @submit.prevent="submit" class="space-y-4">

                    <!-- Semester -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Semester
                        </label>
                        <select
                            v-model="form.semester_id"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option
                                v-for="semester in semesters"
                                :key="semester.id"
                                :value="semester.id"
                            >
                                {{ semester.course.name }} → {{ semester.name }}
                            </option>
                        </select>
                        <p v-if="form.errors.semester_id" class="text-sm text-red-500 mt-1">
                            {{ form.errors.semester_id }}
                        </p>
                    </div>

                    <!-- Section Name -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Section Name
                        </label>
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="A / B / C"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <p v-if="form.errors.name" class="text-sm text-red-500 mt-1">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Capacity
                        </label>
                        <input
                            v-model="form.capacity"
                            type="number"
                            placeholder="Optional"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <p v-if="form.errors.capacity" class="text-sm text-red-500 mt-1">
                            {{ form.errors.capacity }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center gap-2">
                        <input
                            id="status"
                            type="checkbox"
                            v-model="form.status"
                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                        />
                        <label for="status" class="text-sm text-gray-700">
                            Active
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="pt-4">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition disabled:opacity-50"
                        >
                            Update Section
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </AppLayout>
</template>
