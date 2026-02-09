<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'

const props = defineProps({
    assignment: Object,
})

const form = useForm({
    text: '',
})
</script>

<template>

    <Head title="Submit Assignment" />
    <div class="max-w-xl w-full mx-auto mt-10 bg-white p-6 rounded-xl shadow">
        <Link href="/Student/dashboard" class="inline-block rounded bg-indigo-600 px-4 py-2 text-sm mb-2 text-white">
            ← Back
        </Link>
        <h2 class="text-lg font-semibold ">
            Q. {{ props.assignment.title }}
        </h2>

        <p class="text-sm text-gray-600 mb-4">
           {{ props.assignment.description }}
        </p>
        <p class="text-sm text-gray-600 mb-4">
            Due: {{ props.assignment.due_date }}
        </p>

        <form @submit.prevent="form.post(
            `/student/assignments/${props.assignment.id}/submit`
        )">
            <p class="text-sm text-gray-600">
                Ans
            </p>
            <textarea v-model="form.text" class="block w-full border text-sm mb-4 p-2"
                required></textarea>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Submit Assignment
            </button>
        </form>
    </div>
</template>
