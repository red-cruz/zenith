<template>
    <v-sheet class="mx-auto mb-4" min-width="200" max-width="265">
        <v-card class="product mx-1" height="330">
            <v-img
                src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
                height="200px"
                cover
            ></v-img>
            <v-card-text class="d-flex flex-column">
                <span>{{ product.name }}</span>
                <h3 class="text-indigo">₱ {{ product.price }}</h3>
                <div class="d-flex text-medium-emphasis">
                    <span class="text-decoration-line-through">
                        {{ product.prev_price }}
                    </span>
                    <span class="ms-2">{{
                        product.price_percentage_diff
                    }}</span>
                </div>
                <div class="d-flex">
                    <v-rating
                        :model-value="product.ratings.rate"
                        color="amber"
                        density="compact"
                        half-increments
                        readonly
                        size="small"
                    />
                    <small class="align-self-end">
                        ({{ product.ratings.rators_count }})
                    </small>
                </div>
            </v-card-text>
        </v-card>
    </v-sheet>
</template>

<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<style lang="scss" scoped>
.product:hover {
    cursor: pointer;
    -webkit-user-select: none; /* Safari */
    -ms-user-select: none; /* IE 10 and IE 11 */
    user-select: none; /* Standard syntax */
}
span {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
</style>
