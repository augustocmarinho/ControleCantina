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
                { path: 'produtos', alias: '', name: 'Produtos', component: () => import('./views/produtos/produtos') },

                /* Funcionários */
                { path: 'funcionarios', alias: '', name: 'Funcionários', component: () => import('./views/funcionarios/funcionarios') },

                /* Produtos */
                { path: 'clientes', alias: '', name: 'Clientes', component: () => import('./views/clientes/clientes') },

                /* Relatório de vendas */
                { path: 'relatorio_vendas', alias: '', name: 'Relatório de vendas', component: () => import('./views/relatorios/vendas.vue') },

                /* Relatório de estoque */
                { path: 'relatorio_estoque', alias: '', name: 'Relatório de estoque', component: () => import('./views/relatorios/estoque') },
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
