export const eventBus = new Vue();

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './views/App'
import Welcome from './views/Welcome'
import Images from './views/Images'
import Notes from './views/Notes'
import PageNotFound from './views/PageNotFound'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'welcome',
            component: Welcome
        },
        {
            path: '/images/',
            name: 'images',
            component: Images,
            children: [
                {
                    name: 'image',
                    path: ':image_id',
                },
            ]
        },
        {
            path: '/notes/',
            name: 'notes',
            component: Notes,
            children: [
                {
                    name: 'note',
                    path: ':note_id',
                },
            ]
        },
        {
            name: 'not-found',
            path: "/404",
            component: PageNotFound
        },
        {
            path: "*",
            redirect: { name: 'not-found' }
        }
    ],
});

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
});
