<template>
    <div>
        <h1>New Product</h1>

        <div class="danger" v-if="error">
            {{ error }}
            {{ errors }}
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
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                error: null,
                errors: null,
                product: {
                    name: '',
                    description: '',
                    price: '',
                    image: '',
                }
            };
        },
        created() {
        },
        methods: {
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
                        console.log(response);
                    })
                    .catch(error => {
                        this.error = error.response.data.message || error.message;
                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }
                    });
            }
        }
    }
</script>
