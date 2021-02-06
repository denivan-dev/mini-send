import Vue from 'vue'
import VueRouter from 'vue-router'
import ApiTest from './views/ApiTest'
import ActivitiesList from './views/ActivitiesList'
import Email from './views/Email'
import EmailsList from './views/EmailsList'

Vue.use(VueRouter)

export default new VueRouter({
    routes: [
        {
            path: '/',
            name: 'Home',
            component: ActivitiesList
        },
        {
            path: '/email',
            name: 'Email',
            component: Email
        },
        {
            path: '/emails-list',
            name: 'EmailsList',
            component: EmailsList
        },
        {
            path: '/api-test',
            name: 'ApiTest',
            component: ApiTest
        },
    ],

    mode: 'history'
})
