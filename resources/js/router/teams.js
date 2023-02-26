import TeamRoot from '../components/projects/teams/TeamRoot';
import CreateTeam from '../components/projects/teams/CreateTeam';
import TeamSingle from '../components/projects/teams/TeamSingle';
import TeamEdit from '../components/projects/teams/TeamEdit';

import TaskRoot from '../components/projects/tasks/TaskRoot';
import CreateTask from '../components/projects/tasks/CreateTask';
import TaskSingle from '../components/projects/tasks/TaskSingle';
import TaskEdit from '../components/projects/tasks/TaskEdit';

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
    name: 'team-edit',
    path: '/teams/:team_id/edit',
    component: TeamEdit,
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
  {
    name: 'task-edit',
    path: '/teams/:team_id/tasks/:task_id/edit',
    component: TaskEdit,
    meta: { requiresAuth: true },
  },
  {
    name: 'new-subtask',
    path: '/teams/:team_id/tasks/:task_id/create',
    component: CreateTask,
    meta: { requiresAuth: true },
  },
];
