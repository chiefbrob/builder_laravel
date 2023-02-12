import TeamRoot from '../components/projects/teams/TeamRoot';

export const teams = [
  {
    name: 'teams',
    path: '/teams',
    component: TeamRoot,
    meta: { requiresAuth: true },
  },
];
