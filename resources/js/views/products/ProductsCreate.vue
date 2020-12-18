<template>
    <div>
        <h1>New Product</h1>

        <div class="danger" v-if="error">
            {{ error }}
        </div>

        <form @submit.prevent="onSubmit($event)" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" v-model="product.name" required>
                <div class="text-danger" v-if="errors && errors.name">
                    {{ errors.name[0] }}
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" v-model="product.description" required></textarea>
                <div class="text-danger" v-if="errors && errors.description">
                    {{ errors.description[0] }}
                </div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" min="0" class="form-control" id="price" v-model="product.price" required>
                <div class="text-danger" v-if="errors && errors.price">
                    {{ errors.price[0] }}
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" v-on:change="onImageChange" required>
                <div class="text-danger" v-if="errors && errors.image">
                    {{ errors.image[0] }}
                </div>
            </div>
            <div class="mb-3">
                <label for="categories" class="form-label">Categories</label>
                <select name="categories" id="categories" v-model="product.categoryIds" multiple>
                    <option value="" selected>---------</option>
                    <option :value="category.id" v-for="category in categories">{{ category.name }}</option>
                </select>
                <div class="text-danger" v-if="errors && errors.categoryIds">
                    {{ errors.categoryIds[0] }}
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    import Multiselect from 'vue-multiselect';

    export default {
        components: {Multiselect},
        data() {
            return {
                error: null,
                errors: null,
                categories: null,
                product: {
                    name: '',
                    description: '',
                    price: '',
                    image: '',
                    categoryIds: [],
                }
            };
        },
        created() {
            this.getCategories();
        },
        methods: {
            getCategories() {
                axios
                    .get('/api/categories')
                    .then(response => {
                        this.categories = response.data.data;
                    })
                    .catch(error => {
                        this.loading = false;
                        this.error = error.response?.data.message || error.message;
                    });
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.product.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            onSubmit() {
                this.error = null;
                this.errors = null;
                axios
                    .post('/api/products', this.product)
                    .then(response => {
                        this.$router.push({ name: 'products.index' });
                    })
                    .catch(error => {
                        this.error = error.response.data.message || error.message;
                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }
                    });
            },
            addTag(newTag) {
                const tag = {
                    name: newTag,
                    id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.categories.push(tag)
                this.product.categoryIds.push(tag)
            }
        }
    }
</script>
