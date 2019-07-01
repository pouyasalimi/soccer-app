import VueRouter from 'vue-router';

// Pages
import Home from './pages/home';
import Register from './pages/register';
import Login from './pages/login';
import Dashboard from './pages/dashboard';
import PlayersIndex from './pages/players/index';
import PlayerShow from './pages/players/show';
import PlayerCreate from './pages/players/create';
import PlayerEdit from './pages/players/edit';

import TeamsIndex from './pages/teams/index';
import TeamsShow from './pages/teams/show';
import TeamsCreate from './pages/teams/create';
import TeamsEdit from './pages/teams/edit';

import PlayerTeamsIndex from './pages/player-teams/index';

// Routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
            auth: undefined
        }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            auth: false
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            auth: true
        }
    },
    {
        path: '/players',
        name: 'players',
        component: PlayersIndex,
        meta: {
            auth: true
        }
    },
    {
        path: '/players/create',
        name: 'playerCreate',
        component: PlayerCreate,
        meta: {
            auth: true
        }
    },
    {
        path: '/players/:id',
        name: 'playerShow',
        component: PlayerShow,
        meta: {
            auth: true
        }
    },
    {
        path: '/players/:id/edit',
        name: 'playerEdit',
        component: PlayerEdit,
        meta: {
            auth: true
        }
    },    {
        path: '/teams',
        name: 'teams',
        component: TeamsIndex,
        meta: {
            auth: true
        }
    },
    {
        path: '/teams/create',
        name: 'teamCreate',
        component: TeamsCreate,
        meta: {
            auth: true
        }
    },
    {
        path: '/teams/:id',
        name: 'teamShow',
        component: TeamsShow,
        meta: {
            auth: true
        }
    },
    {
        path: '/teams/:id/edit',
        name: 'teamEdit',
        component: TeamsEdit,
        meta: {
            auth: true
        }
    },
    {
        path: '/player/teams',
        name: 'playerTeamsIndex',
        component: PlayerTeamsIndex,
        meta: {
            auth: true
        }
    },
];
const router = new VueRouter({
    history: true,
    mode: 'history',
    routes,
});

export default router;
