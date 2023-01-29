import { createRouter as _createRouter, createWebHistory } from 'vue-router';

const HomeRoot = () => import('../components/home/HomeRoot.vue');
const Foo = () => import('../components/Foo.vue');

import System from './system';
import Blog from './blog';
import Shop from './shop';

const routeCollections = [Blog, Shop, System];

export function createRouter() {
  return _createRouter({
    history: createWebHistory(),
    scrollBehavior: () => ({ top: 0 }),
    routes: routeCollections.flat(),
    // routes: [
    //   { path: '/', component: Foo },
    //   { path: '/home', component: HomeRoot },
    //   { path: '/test', redirect: '/' },
    // ],
  });
}
