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
                <div class="text-subtitle-1 text-medium-emphasis">Account</div>
                <v-text-field
                    type="email"
                    name="email"
                    autocomplete="username"
                    density="compact"
                    placeholder="Email address"
                    prepend-inner-icon="mdi-email-outline"
                    variant="outlined"
                    aria-required="true"
                    required
                ></v-text-field>
                <div
                    class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between"
                >
                    Password

                    <a
                        class="text-caption text-decoration-none text-blue"
                        href="/reset-password"
                        rel="noopener noreferrer"
                    >
                        Forgot login password?</a
                    >
                </div>

                <v-text-field
                    name="password"
                    autocomplete="current-password"
                    :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                    :type="visible ? 'text' : 'password'"
                    density="compact"
                    placeholder="Enter your password"
                    prepend-inner-icon="mdi-lock-outline"
                    variant="outlined"
                    aria-required="true"
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
