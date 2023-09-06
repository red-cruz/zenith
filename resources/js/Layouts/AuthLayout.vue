<template>
    <v-layout class="rounded rounded-md">
        <v-app-bar color="surface-variant" title="Application bar"></v-app-bar>

        <v-navigation-drawer>
            <v-list>
                <v-list-item title="Drawer left"></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-navigation-drawer location="right">
            <v-list>
                <v-list-item title="Drawer right"></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main
            class="d-flex align-center justify-center"
            style="min-height: 300px"
        >
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

                    <form
                        id="login-form"
                        method="post"
                        action="/login"
                        novalidate
                    >
                        <v-text-field
                            type="email"
                            name="email"
                            label="Email"
                            prepend-inner-icon="mdi-email-outline"
                            autocomplete="username"
                            required
                        ></v-text-field>

                        <v-text-field
                            :append-inner-icon="
                                visible ? 'mdi-eye-off' : 'mdi-eye'
                            "
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
                            Sign up now
                            <v-icon icon="mdi-chevron-right"></v-icon>
                        </a>
                    </v-card-text>
                </v-card>
            </div>
        </v-main>
    </v-layout>
</template>
