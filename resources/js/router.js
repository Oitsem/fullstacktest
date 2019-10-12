import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

const Home = () => import('./views/Home');

/**
 * Guests
 *
 */
const GuestsIndex = () => import('./views/guests/Index');
const GuestsCreate = () => import('./views/guests/Create');
const GuestsView = () => import('./views/guests/View');
const GuestsEdit = () => import('./views/guests/Edit');

/**
 * Users
 *
 */
const UsersIndex = () => import('./views/users/Index');
const UsersCreate = () => import('./views/users/Create');
const UsersView = () => import('./views/users/View');
const UsersEdit = () => import('./views/users/Edit');

const router = new Router({
  mode: 'history',
  routes: [
    // Home
    { path: '/', name: 'home', component: Home },

    // Guests
    { path: '/guests', name: 'guests.index', component: GuestsIndex },
    { path: '/guests/create', name: 'guests.create', component: GuestsCreate },
    { path: '/guests/:id', name: 'guests.view', component: GuestsView },
    { path: '/guests/:id/edit', name: 'guests.edit', component: GuestsEdit },

    // Users
    { path: '/users', name: 'users.index', component: UsersIndex },
    { path: '/users/create', name: 'users.create', component: UsersCreate },
    { path: '/users/:id', name: 'users.view', component: UsersView },
    { path: '/users/:id/edit', name: 'users.edit', component: UsersEdit }
  ]
});

export default router;
