<template>
    <div>
        <v-card
            class="mx-auto mt-1 pa-12 pb-8"
            elevation="8"
            max-width="448"
            rounded="lg"
        >
            <v-img
                class="mx-auto mb-2"
                max-width="100"
                src="img/zenith.png"
            ></v-img>

            <form id="login-form" method="post" action="/login" novalidate>
                <v-text-field
                    type="email"
                    name="email"
                    label="Email"
                    prepend-inner-icon="mdi-email-outline"
                    autocomplete="username"
                    required
                ></v-text-field>

                <v-text-field
                    :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visible ? 'text' : 'password'"
                    name="password"
                    label="Password"
                    prepend-inner-icon="mdi-lock-outline"
                    autocomplete="username"
                    required
                    @click:append-inner="visible = !visible"
                ></v-text-field>

                <v-btn
                    type="submit"
                    block
                    class="mb-8"
                    color="blue"
                    size="large"
                    variant="tonal"
                >
                    Log In
                </v-btn>
            </form>
            <v-card-text class="text-center">
                <a
                    class="text-blue text-decoration-none"
                    href="/signup"
                    rel="noopener noreferrer"
                >
                    Sign up now <v-icon icon="mdi-chevron-right"></v-icon>
                </a>
            </v-card-text>
        </v-card>
    </div>
</template>
<script setup>
import Vts from "vts.js";
import Swal from "sweetalert2";
import { onMounted } from "vue";

defineProps({ visible: Boolean, testdata: String });
onMounted(() => {
    new Vts("login-form", {
        ajax: {
            beforeSend: (requestInit, abortController, form) => {
                // Disable the submit button to prevent the user from submitting the form multiple times.
                form.querySelector('[type="submit"]').disabled = true;
                // Show a loading modal while the request is being processed

                Swal.fire({
                    title: "Logging in...",
                    icon: "info",
                    text: "Please wait.",
                    // allowOutsideClick: false,
                    showCancelButton: true,
                    showConfirmButton: false,
                    cancelButtonText: "Cancel",
                }).then((result) => {
                    // If the user cancels the request, abort the Ajax request.
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        abortController.abort();
                    }
                });
            },
            success: () => {
                const f = 4;
                f += 4;
                window.location.reload();
            },
        },
    });
});
</script>
