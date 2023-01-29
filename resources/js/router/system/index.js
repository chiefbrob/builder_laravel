export default [
  {
    path: '/',
    name: 'welcome',
    component: () => import('../../components/WelcomeRoot.vue'),
    meta: { requiresAuth: false },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('../../components/auth/RegisterUser.vue'),
    meta: { requiresAuth: false },
  },
];
