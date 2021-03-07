import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
import home from './component/pages/home.vue';
import tag from './admin/pages/tags.vue';
import category from './admin/pages/category.vue';
import user from './admin/pages/user.vue'
import login from './admin/pages/login.vue'
import role from './admin/pages/role.vue'
import assignRole from './admin/pages/assignRoles.vue'
import blog from    './admin/pages/blog.vue'
const routes = [

    {
        path: '/',
        component:home,
        name:'home'
    },
    {
        path: '/tags',
        component:tag,
        name:'tags'
    },
    {
        path: '/category',
        component:category,
        name:'category'
    },
    {
        path: '/user',
        component:user,
        name:'user'
    },
    {
        path: '/role',
        component:role,
        name:'role'
    },
    {
        path: '/login',
        component:login,
        name:'login'
    },
    {
        path: '/assignRole',
        component:assignRole,
        name:'assignRole'
    },
    {
        path: '/blog',
        component:blog,
        name:'blog'
    }

];

export default new Router({
    mode:'history',
    routes
})
