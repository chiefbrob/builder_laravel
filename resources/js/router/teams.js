import TeamRoot from '../components/projects/teams/TeamRoot';
import CreateTeam from '../components/projects/teams/CreateTeam';
import TeamSingle from '../components/projects/teams/TeamSingle';

export const teams = [
  {
    name: 'teams',
    path: '/teams',
    component: TeamRoot,
    meta: { requiresAuth: true },
  },
  {
    name: 'new-team',
    path: '/teams/create',
    component: CreateTeam,
    meta: { requiresAdmin: true },
  },
  {
    name: 'team-single',
    path: '/teams/:id',
    component: TeamSingle,
    meta: { requiresAuth: true },
  },
];
