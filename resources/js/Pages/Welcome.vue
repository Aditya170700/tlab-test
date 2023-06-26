<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <div v-if="canLogin" class="flex justify-center items-center h-screen">
        <Head title="Dashboard" />

        <Link
            v-if="$page.props.auth.user"
            :href="route('dashboard')"
            class="font-semibold text-gray-700 hover:text-white hover:bg-gray-700 border px-5 py-1 border-gray-700 rounded-md"
            >Dashboard</Link
        >

        <template v-else>
            <Link
                :href="route('login')"
                class="font-semibold text-gray-700 hover:text-white hover:bg-gray-700 border px-5 py-1 border-gray-700 rounded-md"
                >Log in</Link
            >

            <Link
                v-if="canRegister"
                :href="route('register')"
                class="ml-4 font-semibold text-gray-700 hover:text-white hover:bg-gray-700 px-5 py-1 rounded-md"
                >Register</Link
            >
        </template>
    </div>
</template>
