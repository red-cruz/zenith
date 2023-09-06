<template>
    <v-app-bar class="d-flex justify-space-between" color="teal-darken-4">
        <template v-slot:image>
            <v-img
                gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"
            >
            </v-img>
        </template>

        <v-app-bar-nav-icon>
            <v-img class="mx-auto" src="/img/zenith.png" width="30"></v-img>
        </v-app-bar-nav-icon>

        <v-app-bar-title>Zenith</v-app-bar-title>

        <v-text-field
            density="compact"
            variant="solo"
            placeholder="Search"
            append-inner-icon="mdi-magnify"
            single-line
            hide-details
            @click:append-inner=""
        ></v-text-field>

        <v-btn icon>
            <v-icon>mdi-cart</v-icon>
        </v-btn>

        <v-btn icon>
            <v-icon>mdi-account</v-icon>
        </v-btn>
    </v-app-bar>
</template>

<script setup></script>

<style lang="scss" scoped></style>
