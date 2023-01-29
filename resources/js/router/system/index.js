export default [
  {
    path: '/',
    name: 'welcome',
    component: () => import('../../components/WelcomeRoot.vue'),
    meta: { requiresAuth: false },
  },
];
