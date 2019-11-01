import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'MainTemplate',
            component: () => import('./Templates/MainTemplate'),
            children: [
                /* Home */
                { path: 'home', alias: '', name: 'Início', component: () => import('./views/Home') },

                
                /* Produtos */
                { path: 'produtos', alias: '', name: 'Início', component: () => import('./views/produtos/produtosListar') },
            ]
        },
        {
            path: "/login",
            name: "Login",
            component: () => import('./views/auth/Login')
        },
        {
            path: "/logout",
            name: "Logout",
            component: () => import('./views/auth/Logout')
        },
    ]
})
