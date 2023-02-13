import TeamRoot from '../components/projects/teams/TeamRoot';
import CreateTeam from '../components/projects/teams/CreateTeam';
import TeamSingle from '../components/projects/teams/TeamSingle';

import TaskRoot from '../components/projects/tasks/TaskRoot';
import CreateTask from '../components/projects/tasks/CreateTask';
import TaskSingle from '../components/projects/tasks/TaskSingle';

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
  {
    name: 'tasks',
    path: '/teams/:team_id/tasks',
    component: TaskRoot,
    meta: { requiresAuth: true },
  },
  {
    name: 'new-task',
    path: '/teams/:team_id/tasks/create',
    component: CreateTask,
    meta: { requiresAuth: true },
  },
  {
    name: 'task-single',
    path: '/teams/:team_id/tasks/:task_id',
    component: TaskSingle,
    meta: { requiresAuth: true },
  },
];
