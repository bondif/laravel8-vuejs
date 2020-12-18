<template>
    <div>
        <h1>Products</h1>

        <router-link :to="{ name: 'products.create' }" class="btn btn-primary" role="button">Add</router-link>

        <div class="container">
            <div class="row">
                <div class="col">
                    Filter by category :
                    <select name="categories" id="categories" @change="onChange($event)" v-model="selectedCategory">
                        <option value="" selected>---------</option>
                        <option :value="category.id" v-for="category in categories">{{ category.name }}</option>
                    </select>
                </div>
                <div class="col">
                    Sort by :
                    <select name="sort" id="sort" @change="onChange($event)" v-model="selectedColumn">
                        <option value="" selected>---------</option>
                        <option value="name">Name</option>
                        <option value="price">Price</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="danger">
            {{ error }}
        </div>

        <div v-if="products && !loading">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Image</th>
                    <th scope="col">Categories</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="product in products">
                    <th scope="row">{{ product.id }}</th>
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.price }}</td>
                    <td>{{ product.image }}</td>
                    <td>{{ product.categoriesStr }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                loading: false,
                products: null,
                categories: null,
                error: null,
                selectedCategory: '',
                selectedColumn: ''
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                this.error = this.products = this.categories = null;
                this.loading = true;
                axios
                    .get('/api/products')
                    .then(response => {
                        this.loading = false;
                        this.products = response.data.data;
                    })
                    .catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });

                axios
                    .get('/api/categories')
                    .then(response => {
                        this.categories = response.data.data;
                    })
                    .catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            },
            onChange() {
                this.error = null;
                this.loading = true
                axios
                    .get('/api/products?category=' + this.selectedCategory + '&sortBy=' + this.selectedColumn)
                    .then(response => {
                        this.loading = false;
                        this.products = response.data.data;
                    })
                    .catch(error => {
                        this.loading = false;
                        this.error = error.response.data.message || error.message;
                    });
            },
        }
    }
</script>
