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
import NewBlog from '../components/blog/NewBlog';
import BlogEdit from '../components/blog/BlogEdit';
import PrivacyPolicy from '../components/pages/PrivacyPolicy';
import ContactRoot from '../components/pages/ContactRoot';
import TermsAndConditions from '../components/pages/TermsAndConditions';

import ShopRoot from '../components/shop/ShopRoot';
import CreateProduct from '../components/shop/CreateProduct';
import EditProduct from '../components/shop/EditProduct';
import ViewProduct from '../components/shop/ViewProduct';

import RegisterUser from '../components/auth/RegisterUser';
import LoginUser from '../components/auth/LoginUser';

export default {
  mode: 'history',
  routes: [
    {
      name: 'register',
      path: '/register',
      component: RegisterUser,
      meta: { requiresAuth: false },
    },
    {
      name: 'login',
      path: '/login',
      component: LoginUser,
      meta: { requiresAuth: false },
    },
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
      name: 'contact',
      path: '/contact',
      component: ContactRoot,
      meta: { requiresAuth: false },
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
      name: 'shop',
      path: '/shop',
      component: ShopRoot,
      meta: { requiresAuth: false },
    },
    {
      name: 'create-product',
      path: '/shop/products/create',
      component: CreateProduct,
      meta: { requiresAdmin: true },
    },
    {
      name: 'view-product',
      path: '/shop/products/:slug',
      component: ViewProduct,
      meta: { requiresAuth: false },
    },
    {
      name: 'edit-product',
      path: '/shop/products/:slug/edit',
      component: EditProduct,
      meta: { requiresAdmin: true },
    },
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
    {
      name: 'terms',
      path: '/terms-and-conditions',
      component: TermsAndConditions,
      meta: { requiresAuth: false },
    },
    {
      name: 'privacy-policy',
      path: '/privacy-policy',
      component: PrivacyPolicy,
      meta: { requiresAuth: false },
    },
    {
      path: '*',
      component: Error404,
    },
  ],
};
