import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './views/App'
import ProductsIndex from './views/products/ProductsIndex'
import ProductsCreate from './views/products/ProductsCreate'
import Home from './views/Home'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/products',
            name: 'products.index',
            component: ProductsIndex,
        },
        {
            path: '/products/create',
            name: 'products.create',
            component: ProductsCreate,
        },
    ],
});

const app = new Vue({
    el: '#app',
    components: {App},
    router,
});
