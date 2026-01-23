import { usePage } from '@inertiajs/vue3'

export function useAuth() {
  const page = usePage()
  const user = page.props.auth?.user

  const hasRole = (role) => {
    return user?.roles?.includes(role)
  }

  const hasAnyRole = (roles = []) => {
    return roles.some(r => user?.roles?.includes(r))
  }

  const can = (permission) => {
    return user?.permissions?.includes(permission)
  }

  return {
    user,
    hasRole,
    hasAnyRole,
    can,
    isAdmin: hasRole('admin'),
    isTeacher: hasRole('teacher'),
    isStudent: hasRole('student'),
  }
}
