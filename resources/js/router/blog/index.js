export default [
  {
    path: '/blog',
    name: 'blog',
    component: () => import('../../components/blog/BlogRoot.vue'),
    meta: { requiresAuth: false },
  },
  {
    path: '/blog/create',
    name: 'blog-new',
    component: () => import('../../components/blog/NewBlog.vue'),
    meta: { requiresAdmin: true },
  },
];
