import Error404 from '../components/errors/Error404';

import PrivacyPolicy from '../components/pages/PrivacyPolicy';
import TermsAndConditions from '../components/pages/TermsAndConditions';
import WelcomeRoot from '../components/WelcomeRoot';
import ContactRoot from '../components/pages/ContactRoot';
import ContactsRoot from '../components/contacts/ContactsRoot';
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
    name: 'contacts',
    path: '/contacts',
    component: ContactsRoot,
    meta: { requiresAuth: true },
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
