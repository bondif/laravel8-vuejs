<template>
    <div>
        <p>
            <router-link :to="{ name: 'home' }">Home</router-link>
            |
            <router-link :to="{ name: 'products.index' }">Products</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>
