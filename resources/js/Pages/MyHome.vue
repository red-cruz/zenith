<template>
    <v-container fluid>
        <v-row no-gutters>
            <v-col v-for="product in products">
                <ProductCard :product="product" />
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
defineProps({
    products: Object,
});
import ProductCard from "../Partials/ProductCard.vue";
</script>
