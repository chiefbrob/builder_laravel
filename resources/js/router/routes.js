import HomeRoot from '../components/home/HomeRoot';
import ProfileRoot from '../components/home/ProfileRoot';
import ProfileEdit from '../components/home/ProfileEdit';
import Settings from '../components/home/Settings';
import Error404 from '../components/errors/Error404';
import WelcomeRoot from '../components/WelcomeRoot';
import AdminDashboard from '../components/admin/AdminDashboard';
import Style from '../components/style/Style';
import BlogRoot from '../components/blog/BlogRoot';
import BlogSingle from '../components/blog/BlogSingle';

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
      name: 'style',
      path: '/style',
      component: Style,
      meta: { requiresAdmin: true },
    },
    {
      name: 'profile',
      path: '/profile',
      component: ProfileRoot,
      meta: { requiresAuth: true },
    },
    {
      name: 'settings',
      path: '/profile/settings/:section?',
      component: Settings,
      meta: { requiresAuth: true },
    },
    {
      name: 'profile-edit',
      path: '/profile/edit',
      component: ProfileEdit,
      meta: { requiresAuth: true },
    },
    {
      name: 'blog',
      path: '/blog',
      component: BlogRoot,
      meta: { requiresAuth: false },
    },
    {
      name: 'blog-single',
      path: '/blog/:id/:long_title?',
      component: BlogSingle,
      meta: { requiresAuth: false },
    },
    {
      path: '*',
      component: Error404,
    },
  ],
};
