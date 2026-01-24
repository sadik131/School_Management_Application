<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link, useForm } from '@inertiajs/vue3'

const breadcrumbs = [
    {
        title: 'Create Course',
        href: dashboard().url,
    },
]

const form = useForm({
    name: '',
    code: '',
    status: true,
})

const formSubmit = () => {
    form.post('/courses')
}
</script>

<template>
    <Head title="Create Course" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

            <!-- Back Button -->
            <div>
                <Link
                    href="/courses"
                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700"
                >
                    Back
                </Link>
            </div>

            <div class="max-w-3xl w-full mx-auto bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">
                    Create Course
                </h2>

                <form @submit.prevent="formSubmit" class="space-y-4">

                    <!-- Course Name -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Course Name
                        </label>
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="e.g. BCA, BSc"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <p v-if="form.errors.name" class="text-sm text-red-500 mt-1">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Course Code -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Course Code
                        </label>
                        <input
                            v-model="form.code"
                            type="text"
                            placeholder="e.g. BCA, BSC-TT"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        />
                        <p v-if="form.errors.code" class="text-sm text-red-500 mt-1">
                            {{ form.errors.code }}
                        </p>
                    </div>

                    <!-- Status -->
                    <div class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            id="status"
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
                            Create Course
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </AppLayout>
</template>
