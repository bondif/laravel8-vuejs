<template>
    <div>
        <h1>Products</h1>

        <div class="loading" v-if="loading">
            Loading...
        </div>

        <div v-if="error" class="error">
            {{ error }}
        </div>

        <div v-if="products">
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
                    });
            }
        }
    }
</script>
