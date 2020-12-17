import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './views/App'
import ProductsIndex from './views/products/ProductsIndex'
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
    ],
});

const app = new Vue({
    el: '#app',
    components: {App},
    router,
});
