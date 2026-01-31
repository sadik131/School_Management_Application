<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Admin Dashboard', href: dashboard().url },
]

const props = defineProps({
    stats: Object
});

const kpiCards = [
    { title: 'Total Students', value: props.stats?.total_students ?? 0, color: 'from-blue-500 to-cyan-400' },
    { title: 'Total Teachers', value: props.stats?.total_teachers ?? 0, color: 'from-purple-500 to-pink-500' },
    { title: 'Total Sections', value: props.stats?.total_section ?? 0, color: 'from-indigo-500 to-violet-500' },
    { title: 'Total Courses', value: props.stats?.total_course ?? 0, color: 'from-emerald-500 to-green-400' },
    { title: 'Assignments', value: props.stats?.total_assignments ?? 0, color: 'from-orange-500 to-red-500' },
    { title: 'Pending Requests', value: props.stats?.pending_assignment ?? 0, color: 'from-gray-700 to-gray-500' },
]

{{props.stats}}

const assignment = [
  {
    id: 1,
    title: 'Algebra Homework',
    subject: 'Mathematics',
    section: '10-A',
    teacher: 'Mr. Roy',
    date: '25 Jan 2026',
  },
  {
    id: 2,
    title: 'English Essay Writing',
    subject: 'English',
    section: '9-B',
    teacher: 'Ms. Sen',
    date: '24 Jan 2026',
  },
  {
    id: 3,
    title: 'Physics Numericals',
    subject: 'Physics',
    section: '10-B',
    teacher: 'Mr. Das',
    date: '23 Jan 2026',
  },
  {
    id: 4,
    title: 'History Chapter Test',
    subject: 'History',
    section: '8-C',
    teacher: 'Ms. Gupta',
    date: '22 Jan 2026',
  },
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
                   bg-linear-to-r transition
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
            
            <!-- ================= ANALYTICS ================= -->
            <section class="bg-white rounded-2xl p-5 shadow">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">New Assignments</h2>
                    <Link href="/assignments" class="text-sm text-blue-600">
                    View All
                    </Link>
                </div>

                <table class="w-full text-sm">
                    <thead class="text-gray-500 border-b">
                        <tr>
                            <th class="py-2 text-left">Title</th>
                            <th class="text-start">Subject</th>
                            <th class="text-start">Section</th>
                            <th class="text-start">Teacher</th>
                            <th class="text-start">Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="a in assignment" :key="a.id" class="border-b">
                            <td class="py-2 font-medium">{{ a.title }}</td>
                            <td>{{ a.subject }}</td>
                            <td>
                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-600">
                                    {{ a.section }}
                                </span>
                            </td>
                            <td>{{ a.teacher }}</td>
                            <td class="text-gray-500">{{ a.date }}</td>
                        </tr>
                    </tbody>
                </table>
            </section>


            <!-- ================= ASSIGNMENTS ================= -->
            <section class="rounded-xl bg-white p-6 shadow">
                <h2 class="mb-4 text-lg font-semibold text-gray-800">
                    Assignment Monitoring
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="border-b  text-gray-500">
                            <tr>
                                <th class="py-2 text-start">Teacher</th>
                                <th class="text-start">Subject</th>
                                <th class="text-start">Class</th>
                                <th class="text-start">Submitted</th>
                                <th class="text-start">Pending</th>
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
