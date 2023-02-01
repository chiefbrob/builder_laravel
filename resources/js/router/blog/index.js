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
  {
    path: '/blog/:id/edit',
    name: 'blog-edit',
    component: () => import('../../components/blog/BlogEdit.vue'),
    meta: { requiresAdmin: true },
  },
  {
    path: '/blog/:id/:long_title?',
    name: 'blog-single',
    component: () => import('../../components/blog/BlogSingle.vue'),
    meta: { requiresAuth: false },
  },
];
