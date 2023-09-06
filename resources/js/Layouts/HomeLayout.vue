<template>
    <Head title="Zenith"></Head>
    <v-layout>
        <NavBar />
        <v-main>
            <slot></slot>
        </v-main>
    </v-layout>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import ProductCard from "../Partials/ProductCard.vue";
import NavBar from "./NavBar.vue";
</script>
