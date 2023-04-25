import AdminDashboard from '../../components/admin/AdminDashboard';
import AdminUsersRoot from '../../components/admin/users/AdminUsersRoot';
import Style from '../../components/style/Style';

export const admin = [
  {
    name: 'admin',
    path: '/admin',
    component: AdminDashboard,
    meta: { requiresAdmin: true },
  },
  {
    name: 'admin.users',
    path: '/admin/users',
    component: AdminUsersRoot,
    meta: { requiresAdmin: true },
  },
  {
    name: 'style',
    path: '/style',
    component: Style,
    meta: { requiresAdmin: true },
  },
];
