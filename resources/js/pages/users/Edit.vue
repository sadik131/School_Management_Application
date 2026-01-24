<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { Head, Link, router, useForm } from '@inertiajs/vue3';

const breadcrumbs = [
    {
        title: 'Edit User',
        href: dashboard().url,
    },
];

const props = defineProps({
    user: Object,
    roles: Array
})

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    role: props.user.roles.length
        ? props.user.roles.map(r => r.name)
        : [],
})

const formSubmit = (id) => {
    router.put(`/users/${id}`, form)
}

</script>

<template>

    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div>
                <Link href="/users" class="px-4 py-2 text-sm text-white bg-indigo-600 rounded hover:bg-indigo-700">
                    back
                </Link>
            </div>
            {{ props.user }}
            <div class="max-w-3xl w-full mx-auto bg-white p-6 rounded-xl shadow-md">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">
                    Create User
                </h2>
                <form @submit.prevent="formSubmit(props.user.id)" class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Name
                        </label>
                        <input v-model="form.name" type="text" placeholder="Enter your name"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <p v-if="form.errors.name" class="text-sm text-red-500 mt-1">{{ form.errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input v-model="form.email" type="email" placeholder="Enter your email"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <p v-if="form.errors.email" class="text-sm text-red-500 mt-1">{{ form.errors.email }}</p>

                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <input v-model="form.password" type="password" placeholder="Enter your password"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <p v-if="form.errors.password" class="text-sm text-red-500 mt-1">{{ form.errors.password }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div v-for="role in roles" :key="role.id"
                            class="flex items-center gap-3 p-2 rounded hover:bg-gray-50">
                            <input type="checkbox" :id="`role-${role.id}`" :value="role.name" v-model="form.role"
                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />

                            <label :for="`role-${role.id}`" class="text-sm text-gray-700 cursor-pointer">
                                {{ role.name }}
                            </label>
                        </div>
                    </div>


                    <!-- Submit Button -->
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
