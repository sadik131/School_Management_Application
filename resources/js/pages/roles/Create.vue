<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { useAuth } from '@/lib/auth';
import { dashboard } from '@/routes';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs = [
    {
        title: 'Role Create',
        href: dashboard().url,
    },
];

defineProps({
    users: Array,
    permissions: Array
})


const form = useForm({
    name: '',
    permissions: [],
})

const formSubmit = () => {
    form.post('/roles')
}

</script>

<template>

    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div>
                <Link href="/roles" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
                    back
                </Link>
            </div>

            <div class="max-w-3xl w-full mx-auto bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">
                    Create Role
                </h2>

                <form @submit.prevent="formSubmit" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Name
                        </label>
                        <input v-model="form.name" type="text" placeholder="Enter role name"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <p v-if="form.errors.name" class="text-sm text-red-500 mt-1">{{ form.errors.name }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div v-for="permission in permissions" :key="permission.id"
                            class="flex items-center gap-3 p-2 rounded hover:bg-gray-50">
                            <input type="checkbox" :id="`permission-${permission.id}`" :value="permission.name"
                                v-model="form.permissions"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">

                            <label :for="`permission-${permission.id}`" class="text-sm text-gray-700 cursor-pointer">
                                {{ permission.name }}
                            </label>
                        </div>
                    </div>


                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                            Create User
                        </button>
                    </div>
                </form>
            </div>


        </div>
    </AppLayout>
</template>
