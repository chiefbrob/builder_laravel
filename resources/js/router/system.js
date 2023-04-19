import Error404 from '../components/errors/Error404';

import PrivacyPolicy from '../components/pages/PrivacyPolicy';
import TermsAndConditions from '../components/pages/TermsAndConditions';
import WelcomeRoot from '../components/WelcomeRoot';
import AdminDashboard from '../components/admin/AdminDashboard';
import Style from '../components/style/Style';
import ContactRoot from '../components/pages/ContactRoot';
import HomeRoot from '../components/home/HomeRoot';
import SearchResults from '../components/search/SearchResults';

export const system = [
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
    name: 'search',
    path: '/search',
    component: SearchResults,
    meta: { requiresAuth: false },
  },
  {
    path: '*',
    name: '404',
    component: Error404,
  },
];
