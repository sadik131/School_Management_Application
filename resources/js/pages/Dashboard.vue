<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head, Link } from '@inertiajs/vue3'
import { ref, onMounted } from 'vue'
import Chart from 'chart.js/auto'
import { nextTick } from 'vue'
import { Eye } from 'lucide-vue-next'

const breadcrumbs = [
    { title: 'Admin Dashboard', href: dashboard().url },
]


const chartRef = ref(null)

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    })
}

onMounted(async () => {

    const assignments = props.stats?.assignment ?? []

    const labels = assignments.map(a => a.title)

    const submittedData = assignments.map(a => a.submitted_count ?? 0)

    const pendingData = assignments.map(a =>
        Math.max(0, (a.total_students ?? 0) - (a.submitted_count ?? 0))
    )


    await nextTick()
    if (!chartRef.value) return

    const ctx = chartRef.value.getContext('2d')

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Submitted',
                    data: submittedData,
                    backgroundColor: 'rgba(34,197,94,0.85)',
                    hoverBackgroundColor: 'rgba(34,197,94,1)',
                    borderRadius: 10,
                    barThickness: 28,
                },
                {
                    label: 'Pending',
                    data: pendingData,
                    backgroundColor: 'rgba(239,68,68,0.85)',
                    hoverBackgroundColor: 'rgba(239,68,68,1)',
                    borderRadius: 10,
                    barThickness: 28,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1200,
                easing: 'easeOutQuart',
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 13,
                            weight: '600',
                        },
                    },
                },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#fff',
                    bodyColor: '#e5e7eb',
                    padding: 12,
                    cornerRadius: 8,
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: '500',
                        },
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)', //  soft grid
                    },
                    ticks: {
                        stepSize: 5,
                        font: {
                            size: 12,
                        },
                    },
                },
            },
        },
    })
})


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

                    <div style="height:300px">
                        <canvas ref="chartRef"></canvas>
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
                            <th class="text-start">Due Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="a in props.stats?.assignment" :key="a.id" class="border-b">
                            <td class="py-2 font-medium">{{ a.title }}</td>
                            <td>{{ a.teacher.department }}</td>
                            <td>
                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-600">
                                    {{ a.section.name }}
                                </span>
                            </td>
                            <td>{{ a.teacher.user.name }}</td>
                            <td class="text-gray-500">{{ formatDate(a.due_date) }}</td>

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
                                <th class="text-start">Section</th>
                                <th class="text-start">Total Student</th>
                                <th class="text-start">Submitted</th>
                                <th class="text-start">Pending</th>
                                <th class="text-start">View</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="row in props.stats?.assignment ?? []" :key="row.teacher"
                                class="border-b last:border-0 hover:bg-gray-50">
                                <td class="py-3 font-medium">{{ row.teacher.user.name }}</td>
                                <td>{{ row.teacher.department }}</td>

                                <td>
                                    <span class="rounded-full bg-indigo-100 px-3 py-1 text-xs text-indigo-700">
                                        {{ row.section.semester.number }}
                                        {{ row.section.name }}
                                    </span>
                                </td>
                                <td>{{ row.total_students }}</td>
                                <td>{{ row.submitted_count }}</td>
                                <td class="font-semibold text-red-500">
                                    {{ Math.max(0, row.total_students - row.submitted_count) }}
                                </td>
                                <td>
                                    <Link :href="`/admin/assignments/${row.id}/results`"
                                    class="text-yellow-600 hover:underline font-medium">
                                    <Eye class="w-5 h-5" />
                                </Link>
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
