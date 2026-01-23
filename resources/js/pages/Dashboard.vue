<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Admin Dashboard', href: dashboard().url },
]

const kpiCards = [
    { title: 'Total Students', value: 1248, color: 'from-blue-500 to-cyan-400' },
    { title: 'Total Teachers', value: 62, color: 'from-purple-500 to-pink-500' },
    { title: 'Total Classes', value: 38, color: 'from-indigo-500 to-violet-500' },
    { title: 'Total Courses', value: 54, color: 'from-emerald-500 to-green-400' },
    { title: 'Assignments', value: 127, color: 'from-orange-500 to-red-500' },
    { title: 'Pending Requests', value: 9, color: 'from-gray-700 to-gray-500' },
]

const assignments = [
    {
        teacher: 'Mr. Roy',
        subject: 'Math',
        class: '10-A',
        submitted: 42,
        pending: 3,
    },
    {
        teacher: 'Ms. Sen',
        subject: 'English',
        class: '9-B',
        submitted: 38,
        pending: 9,
    },
]

const attendanceRows = [
    {
        class: '9',
        section: 'A',
        present: 96,
        absent: 4,
    },
    {
        class: '9',
        section: 'B',
        present: 88,
        absent: 12,
    },
    {
        class: '10',
        section: 'A',
        present: 93,
        absent: 7,
    },
    {
        class: '8',
        section: 'C',
        present: 71,
        absent: 29,
    },
]


</script>


<template>

    <Head title="Admin Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-8 p-4">

            <!-- ================= KPI ================= -->
            <section>
                <h2 class="mb-4 text-lg font-semibold text-gray-700">
                    System Overview
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                    <div v-for="card in kpiCards" :key="card.title" class="rounded-xl p-4 text-white shadow-lg
                   bg-gradient-to-r transition
                   hover:-translate-y-1 hover:shadow-xl" :class="card.color">
                        <p class="text-sm opacity-80">{{ card.title }}</p>
                        <p class="mt-2 text-3xl font-bold">{{ card.value }}</p>
                    </div>
                </div>
            </section>

            <!-- ================= ANALYTICS ================= -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Chart -->
                <div class="lg:col-span-2 rounded-xl bg-white p-6 shadow">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800">
                        Student Growth Analytics
                    </h2>

                    <div class="flex h-56 items-center justify-center
                   rounded-lg border-2 border-dashed
                   text-gray-400">
                        📊 Analytics Chart (Dummy)
                    </div>
                </div>

                <!-- Insights -->
                <div class="rounded-xl bg-white p-6 shadow">
                    <h2 class="mb-4 text-lg font-semibold text-gray-800">
                        Quick Insights
                    </h2>

                    <ul class="space-y-3 text-sm text-gray-700">
                        <li class="flex justify-between">
                            <span>🏆 Best Class</span>
                            <b>9-A</b>
                        </li>
                        <li class="flex justify-between">
                            <span>⚠️ Low Attendance</span>
                            <b>8-C</b>
                        </li>
                        <li class="flex justify-between">
                            <span>👩‍🏫 Top Teacher</span>
                            <b>Ananya</b>
                        </li>
                        <li class="flex justify-between">
                            <span>📚 Heavy Subject</span>
                            <b>Mathematics</b>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- ================= ASSIGNMENTS ================= -->
            <section class="rounded-xl bg-white p-6 shadow">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">
                    Assignment Monitoring
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b text-gray-500">
                            <tr>
                                <th class="py-2">Teacher</th>
                                <th>Subject</th>
                                <th>Class</th>
                                <th>Submitted</th>
                                <th>Pending</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="row in assignments" :key="row.teacher"
                                class="border-b last:border-0 hover:bg-gray-50">
                                <td class="py-3 font-medium">{{ row.teacher }}</td>
                                <td>{{ row.subject }}</td>
                                <td>
                                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs text-indigo-700">
                                        {{ row.class }}
                                    </span>
                                </td>
                                <td>{{ row.submitted }}</td>
                                <td class="font-semibold text-red-500">
                                    {{ row.pending }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- ================= ATTENDANCE MONITORING ================= -->
            <div class="rounded-xl bg-white p-6 shadow">
                <h2 class="mb-4 text-xl font-semibold">
                    Attendance Monitoring
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b text-gray-500">
                            <tr>
                                <th class="py-2">Class</th>
                                <th>Section</th>
                                <th>Present %</th>
                                <th>Absent %</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="row in attendanceRows" :key="row.class + row.section"
                                class="border-b last:border-0 hover:bg-gray-50">
                                <td class="py-2 font-medium">
                                    {{ row.class }}
                                </td>

                                <td>
                                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs text-indigo-700">
                                        {{ row.section }}
                                    </span>
                                </td>

                                <td class="font-semibold text-green-600">
                                    {{ row.present }}%
                                </td>

                                <td class="font-semibold text-red-500">
                                    {{ row.absent }}%
                                </td>

                                <td>
                                    <span v-if="row.present >= 90"
                                        class="rounded-full bg-green-100 px-3 py-1 text-xs text-green-700">
                                        Good
                                    </span>

                                    <span v-else class="rounded-full bg-red-100 px-3 py-1 text-xs text-red-700">
                                        Warning
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </AppLayout>
</template>
