import RolesRoot from '../../components/admin/roles/RolesRoot';
import CreateRole from '../../components/admin/roles/CreateRole';
import RoleSingle from '../../components/admin/roles/RoleSingle';

export const roles = [
  {
    name: 'roles',
    path: '/roles',
    component: RolesRoot,
    meta: { requiresAdmin: true },
  },
  {
    name: 'new-role',
    path: '/roles/create',
    component: CreateRole,
    meta: { requiresAdmin: true },
  },
  {
    name: 'role-single',
    path: '/roles/:role_id',
    component: RoleSingle,
    meta: { requiresAdmin: true },
  },
];
