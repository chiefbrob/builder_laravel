import HomeRoot from '../components/home/HomeRoot';
import ProfileRoot from '../components/home/ProfileRoot';
import ProfileEdit from '../components/home/ProfileEdit';
import Error404 from '../components/errors/Error404';
import WelcomeRoot from '../components/WelcomeRoot';
import AdminDashboard from '../components/admin/AdminDashboard';
import Style from '../components/style/Style';

export default {
  mode: 'history',
  routes: [
    {
      name: 'welcome',
      path: '/',
      component: WelcomeRoot,
      meta: { requiresAuth: false },
    },
    {
      name: 'home',
      path: '/home',
      component: HomeRoot,
      meta: { requiresAuth: true },
    },
    {
      name: 'admin',
      path: '/home/admin',
      component: AdminDashboard,
      meta: { requiresAdmin: true },
    },
    {
      name: 'style',
      path: '/home/style',
      component: Style,
      meta: { requiresAdmin: true },
    },
    {
      name: 'profile',
      path: '/home/profile',
      component: ProfileRoot,
      meta: { requiresAuth: true },
    },
    {
      name: 'profile-edit',
      path: '/home/profile/edit',
      component: ProfileEdit,
      meta: { requiresAuth: true },
    },
    {
      // will match everything
      path: '*',
      component: Error404,
    },
  ],
};
