import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export function useAuth() {
    const page = usePage()

    const roles = computed(() => page.props.auth?.roles ?? [])
    const permissions = computed(() => page.props.auth?.permissions ?? [])

    const hasRole = (role) => roles.value.includes(role)

    const hasAnyRole = (checkRoles) =>
        checkRoles.some(r => roles.value.includes(r))

    const can = (permission) =>
        permissions.value.includes(permission)

    return { hasRole, hasAnyRole, can }
}
