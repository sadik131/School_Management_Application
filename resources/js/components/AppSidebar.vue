<script setup>
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { useAuth } from '@/lib/auth'
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { dashboard } from '@/routes';
import { Link } from '@inertiajs/vue3';
import { UserPen, CircleUserRound, Lock, CopyCheck, LayoutGrid, Users, Bot, Shapes } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const { hasRole, hasAnyRole, can } = useAuth()
import { computed } from 'vue'


const mainNavItems = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'TeacherDash',
        href: "/TeacherDash",
        icon: CircleUserRound,
        roles: ['teacher', 'admin'],
    },
    {
        title: 'Users',
        href: '/users',
        icon: Users,
        roles: ['admin'],
    },
    {
        title: 'Permission',
        href: '/permission',
        icon: Lock,
        roles: ['admin'],
    },
    {
        title: 'Profile',
        href: '/profile',
        icon: UserPen,
    },
    {
        title: 'Ai',
        href: '/boat',
        icon: Bot,
    },
    {
        title: '/teacher/assignments',
        href: '/teacher/assignments',
        // roles: ['teacher'],
        icon: Shapes,
    },
    {
        title: '/teacher/assignments/check',
        href: '/teacher/assignments/check',
        // roles: ['teacher'],
        icon: CopyCheck,
    },

];

const filteredNavItems = computed(() => {
    return mainNavItems.filter(item => {
        // no restriction → visible to all
        if (!item.roles && !item.permissions) {
            return true
        }

        // role based
        if (item.roles && hasAnyRole(item.roles)) {
            return true
        }

        // permission based
        if (item.permissions && item.permissions.some(p => can(p))) {
            return true
        }

        return false
    })
})


</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="filteredNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <!-- <NavFooter :items="footerNavItems" /> -->
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
