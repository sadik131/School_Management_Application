<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

const props = defineProps<{
  assignments: Array<any>
  totalAssignments: number
}>()
</script>

<template>

  <Head title="My Assignments" />

  <AppLayout>
    <div class="space-y-6 p-4">

      <!-- ================= HEADER ================= -->
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-2xl font-semibold text-gray-800">
            📘 My Assignments
          </h2>
          <p class="text-sm text-gray-500">
            Total Assignments: <b>{{ totalAssignments }}</b>
          </p>
        </div>

        <Link href="/teacher/assignments/create" class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white shadow
                 hover:bg-blue-700">
          ➕ New Assignment
        </Link>
      </div>

      <!-- ================= ASSIGNMENT LIST ================= -->
      <div v-if="assignments.length" class="grid grid-cols-1 gap-4">

        <div v-for="a in assignments" :key="a.id" class="rounded-xl border bg-white p-5 shadow-sm
                 transition hover:-translate-y-0.5 hover:shadow-md">
          <div class="flex items-center justify-between gap-4">

            <!-- LEFT INFO -->
            <div class="space-y-2">
              <h3 class="text-lg font-semibold text-gray-800">
                {{ a.title }}
              </h3>

              <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">

                <span class="rounded-full bg-indigo-100 px-3 py-1 text-indigo-700">
                  {{ a.section.semester.course.code }}
                  · {{ a.section.semester.name }}
                  · Section {{ a.section.name }}
                </span>

                <span>
                  📅 Due:
                  <b class="text-gray-700">
                    {{ a.due_date }}
                  </b>
                </span>
              </div>
            </div>

            <!-- RIGHT ACTION -->
            <Link :href="`/teacher/sections/${a.section.id}/assignments`" class="rounded-lg bg-green-600 px-4 py-2 text-sm text-white
                     shadow hover:bg-green-700 whitespace-nowrap">
              Check →
            </Link>
          </div>
        </div>

      </div>

      <!-- ================= EMPTY STATE ================= -->
      <div v-else class="rounded-xl border border-dashed p-10 text-center text-gray-400">
        No assignments created yet 📭
      </div>

    </div>
  </AppLayout>
</template>
