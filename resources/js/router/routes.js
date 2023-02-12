import { teams } from './teams';
import { blog } from './blog';
import { shop } from './shop';
import { auth } from './auth';
import { system } from './system';

const routes = [...teams, ...blog, ...shop, ...auth, ...system];

export default {
  mode: 'history',
  routes: routes,
};
