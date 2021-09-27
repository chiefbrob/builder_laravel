import HomeRoot from '../components/home/HomeRoot';
import Error404 from '../components/errors/Error404';
import WelcomeRoot from '../components/WelcomeRoot';

export default {
  mode: 'history',
  routes: [
    {
      name: 'welcome',
      path: '/',
      component: WelcomeRoot,
      meta: { requiresAuth: true },
    },
    {
      name: 'home',
      path: '/home',
      component: HomeRoot,
      meta: { requiresAuth: true },
    },
    {
      // will match everything
      path: '*',
      component: Error404,
    },
  ],
};
