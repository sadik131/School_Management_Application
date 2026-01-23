<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const assignments = [
    { id: 1, title: 'Algebra Worksheet', class: '10-A', due: '25 Jan' },
    { id: 2, title: 'English Essay', class: '9-B', due: '27 Jan' },
]
</script>

<template>
    <Head title="My Assignments" />

    <AppLayout>
        <div class="space-y-6">

            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-semibold text-gray-800">
                    📘 My Assignments
                </h2>

                <button
                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white shadow
                           hover:bg-blue-700"
                >
                    ➕ New Assignment
                </button>
            </div>

            <!-- Assignment Cards -->
            <div class="grid grid-cols-1 gap-4">

                <div
                    v-for="a in assignments"
                    :key="a.id"
                    class="rounded-xl border bg-white p-5 shadow-sm
                           transition hover:-translate-y-0.5 hover:shadow-md"
                >
                    <div class="flex items-center justify-between">

                        <!-- Left -->
                        <div class="space-y-1">
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ a.title }}
                            </h3>

                            <div class="flex items-center gap-3 text-sm text-gray-500">
                                <span
                                    class="rounded-full bg-indigo-100 px-3 py-1
                                           text-indigo-700"
                                >
                                    Class {{ a.class }}
                                </span>

                                <span>
                                    📅 Due: <b>{{ a.due }}</b>
                                </span>
                            </div>
                        </div>

                        <!-- Right -->
                        <Link
                            href="/teacher/assignments/check"
                            class="rounded-lg bg-green-600 px-4 py-2 text-sm text-white
                                   shadow hover:bg-green-700"
                        >
                            Check →
                        </Link>
                    </div>
                </div>

            </div>

            <!-- Empty State (future use) -->
            <div
                v-if="assignments.length === 0"
                class="rounded-xl border border-dashed p-10 text-center text-gray-400"
            >
                No assignments yet 📭
            </div>

        </div>
    </AppLayout>
</template>
