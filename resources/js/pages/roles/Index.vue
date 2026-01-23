<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { Head, Link, router } from '@inertiajs/vue3';

const breadcrumbs = [
    {
        title: 'Roles page',
        href: dashboard().url,
    },
];

defineProps({
    roles: Array
})

const handleDelete = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(`/roles/${id}`)
    }
}

</script>

<template>

    <Head title="Roles" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div>
                <Link href="/roles/create"
                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
                    Create Roles
                </Link>
            </div>
            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full border border-gray-200">
                    <!-- Table Head -->
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Permissions</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="role in roles" :key="role.id" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ role.id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ role.name }}</td>
                            <td class="px-6 flex flex-wrap gap-2 py-4 text-sm font-medium text-gray-900">
                                <span v-for="permission in role.permissions" :key="permission.id"
                                    class="bg-green-500 text-white text-xs px-2 py-1 rounded">
                                    {{ permission.name }}
                                </span>
                            </td>

                            <td class="px-6 py-4  text-center space-x-2">
                                <Link :href="`/roles/${role.id}/edit`"
                                    class="px-3 py-1 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
                                    Edit
                                </Link>

                                <button @click="handleDelete(role.id)"
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
