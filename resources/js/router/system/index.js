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
  {
    path: '/login',
    name: 'login',
    component: () => import('../../components/auth/LoginUser.vue'),
    meta: { requiresAuth: false },
  },
  {
    path: '/home',
    name: 'home',
    component: () => import('../../components/home/HomeRoot.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import('../../components/pages/ContactRoot.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/admin',
    name: 'admin',
    component: () => import('../../components/admin/AdminDashboard.vue'),
    meta: { requiresAdmin: true },
  },
  {
    path: '/style',
    name: 'style',
    component: () => import('../../components/style/Style.vue'),
    meta: { requiresAdmin: true },
  },
  {
    path: '/profile',
    name: 'profile',
    component: () => import('../../components/home/ProfileRoot.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/settings',
    name: 'settings',
    component: () => import('../../components/home/Settings.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/profile/edit',
    name: 'profile-edit',
    component: () => import('../../components/home/ProfileEdit.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/terms-and-conditions',
    name: 'terms',
    component: () => import('../../components/pages/TermsAndConditions.vue'),
    meta: { requiresAuth: false },
  },
  {
    path: '/privacy-policy',
    name: 'privacy-policy',
    component: () => import('../../components/pages/PrivacyPolicy.vue'),
    meta: { requiresAuth: false },
  },
  {
    path: '/:catchAll(.*)',
    name: 'NotFound',
    component: import('../../components/errors/Error404.vue'),
  },
];
