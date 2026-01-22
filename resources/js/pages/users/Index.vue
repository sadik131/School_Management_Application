<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';

const breadcrumbs = [
    {
        title: 'Users page',
        href: dashboard().url,
    },
];

const props = defineProps({
    users: Object,
    filters: Object,
})

const filters = reactive({
    search: props.filters.search || '',
    role: props.filters.role || '',
    status: props.filters.status || '',
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

const handleDelete = (id) => {
    if (confirm('Are you sure?')) {
        router.delete(`/users/${id}`)
    }
}

</script>

<template>

    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div>
                <Link href="/users/create"
                    class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
                    Create User
                </Link>
            </div>
            <!-- filter option -->

            <div class="bg-white p-4 rounded-xl shadow-md flex flex-wrap gap-3 items-center">

                <!-- Search -->
                <input v-model="filters.search" type="text" placeholder="Search name or email..."
                    class="border rounded px-3 py-2 text-sm w-56" />

                <!-- Role -->
                <select v-model="filters.role" class="border rounded px-3 py-2 text-sm">
                    <option value="">All Roles</option>
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>

                <!-- Status -->
                <select v-model="filters.status" class="border rounded px-3 py-2 text-sm">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="blocked">Blocked</option>
                </select>

                <!-- Reset -->
                <button @click="resetFilters" class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
                    Reset
                </button>

            </div>

            <div class="overflow-x-auto bg-white rounded-xl shadow-md">
                <table class="min-w-full border border-gray-200">
                    <!-- Table Head -->
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Role</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Action</th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200">
                        <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-700">{{ user.id }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ user.name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ user.email }}</td>
                            <td class="px-6 py-4">
                                <span v-for="role in user.roles" :key="role.id"
                                    class="px-3 py-1 mr-1 text-xs font-semibold text-blue-700 bg-blue-100 rounded-full">
                                    {{ role.name }}
                                </span>
                            </td>
                           
                            <td class="px-6 py-4">
                                <span :class="'active' === 'active'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-red-100 text-red-700'" class="px-3 py-1 text-xs font-semibold rounded-full">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
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

        </div>
    </AppLayout>
</template>
