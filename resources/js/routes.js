import Home from './components/Home.vue';
import Register from './components/Register.vue';
import Login from './components/Login.vue';
import UserProfile from './components/UserProfile.vue';
import AllUser from './components/AllUser.vue';
import CreateUser from './components/CreateUser.vue';
import EditUser from './components/EditUser.vue';

export const routes = [{
        name: 'home',
        path: '/home',
        component: Home
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'index',
        path: '/',
        component: Login
    },
    {
        name: 'register',
        component: Register,
        path: '/register',
    },
    {
        name: 'user-profile',
        component: UserProfile,
        path: '/user-profile',
    },
    {
        name: 'users',
        path: '/users',
        component: AllUser
    },
    {
        name: 'users-create',
        path: '/users/create',
        component: CreateUser
    },
    {
        name: 'users-edit',
        path: '/users/:id',
        component: EditUser,
        meta: {
            requiresAuth: true,
        },
    }
];