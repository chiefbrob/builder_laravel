import RegisterUser from '../components/auth/RegisterUser';
import LoginUser from '../components/auth/LoginUser';
import ProfileRoot from '../components/home/ProfileRoot';
import ProfileEdit from '../components/home/ProfileEdit';
import Settings from '../components/home/Settings';

export const auth = [
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
];
