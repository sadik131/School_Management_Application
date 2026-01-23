<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs = [
    {
        title: 'Permission Create',
        href: dashboard().url,
    },
];

const form = useForm({
    name: '',
    description: '',
})

const formSubmit = () => {
    form.post('/permission')
}
</script>

<template>

    <Head title="Create Permission" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div>
                <Link
                    href="/permission"
                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700"
                >
                    back
                </Link>
            </div>

            <div class="max-w-3xl w-full mx-auto bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">
                    Create Permission
                </h2>

                <form @submit.prevent="formSubmit" class="space-y-4">

                    <!-- Permission Name -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Permission Name
                        </label>

                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="e.g. manage_assignments"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >

                        <p v-if="form.errors.name" class="text-sm text-red-500 mt-1">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Permission Description -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Description
                        </label>

                        <textarea
                            v-model="form.description"
                            rows="3"
                            placeholder="Describe what this permission allows the user to do"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        ></textarea>

                        <p v-if="form.errors.description" class="text-sm text-red-500 mt-1">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition"
                        >
                            Create Permission
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </AppLayout>
</template>
