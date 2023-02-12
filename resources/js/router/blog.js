import BlogRoot from '../components/blog/BlogRoot';
import BlogSingle from '../components/blog/BlogSingle';
import NewBlog from '../components/blog/NewBlog';
import BlogEdit from '../components/blog/BlogEdit';

export const blog = [
  {
    name: 'blog',
    path: '/blog',
    component: BlogRoot,
    meta: { requiresAuth: false },
  },
  {
    name: 'blog-new',
    path: '/blog/create',
    component: NewBlog,
    meta: { requiresAdmin: true },
  },
  {
    name: 'blog-edit',
    path: '/blog/:id/edit',
    component: BlogEdit,
    meta: { requiresAdmin: true },
  },
  {
    name: 'blog-single',
    path: '/blog/:id/:long_title?',
    component: BlogSingle,
    meta: { requiresAuth: false },
  },
];
