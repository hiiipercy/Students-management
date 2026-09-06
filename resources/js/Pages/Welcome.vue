<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
        default: true,
    },
    canRegister: {
        type: Boolean,
        default: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden bg-slate-950 px-4 text-white"
    >
        <!-- Decorative background glows -->
        <div
            class="pointer-events-none absolute -top-40 left-1/2 h-[28rem] w-[28rem] -translate-x-1/2 rounded-full bg-indigo-600/25 blur-3xl"
        ></div>
        <div
            class="pointer-events-none absolute -bottom-24 -right-24 h-96 w-96 rounded-full bg-fuchsia-600/15 blur-3xl"
        ></div>
        <div
            class="pointer-events-none absolute -bottom-24 -left-24 h-80 w-80 rounded-full bg-sky-500/10 blur-3xl"
        ></div>

        <main class="relative z-10 flex flex-col items-center text-center">
            <!-- Logo mark -->
            <div
                class="mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-fuchsia-500 shadow-lg shadow-indigo-500/40"
            >
                <svg
                    class="h-8 w-8 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13.5 4.5 21 12l-7.5 7.5M3 12h18"
                    />
                </svg>
            </div>

            <!-- Heading -->
            <h1
                class="text-4xl font-bold tracking-tight sm:text-5xl"
            >
                Welcome to Student Management App
            </h1>

            <p
                class="mt-4 max-w-md text-sm/relaxed text-slate-400 sm:text-base/relaxed"
            >
                Sign in to your account or create a new one to get started.
            </p>

            <!-- Auth buttons -->
            <div class="mt-10 flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:gap-4">
                <template v-if="canLogin">
                    <Link
                        :href="route('login')"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-8 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-white/10 transition hover:bg-slate-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950"
                    >
                        Log in
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-600/30 transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950"
                    >
                        Register
                    </Link>
                </template>

                <Link
                    v-else
                    :href="route('dashboard')"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-8 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-white/10 transition hover:bg-slate-200"
                >
                    Go to Dashboard
                </Link>
            </div>
        </main>

        <footer
            class="absolute bottom-6 text-xs text-slate-500"
        >
            © {{ new Date().getFullYear() }} Your App. All rights reserved.
        </footer>
    </div>
</template>