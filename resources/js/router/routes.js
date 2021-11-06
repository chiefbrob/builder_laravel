import HomeRoot from '../components/home/HomeRoot';
import Error404 from '../components/errors/Error404';
import WelcomeRoot from '../components/WelcomeRoot';
import AdminDashboard from '../components/admin/AdminDashboard';

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
      path: '/admin',
      component: AdminDashboard,
      meta: { requiresAdmin: true },
    },
    {
      // will match everything
      path: '*',
      component: Error404,
    },
  ],
};
