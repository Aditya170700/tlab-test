<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap items-center mt-8">
            <div v-for="(link, i) in links" :key="i">
                <div
                    v-if="link.url === null"
                    class="mr-1 px-4 py-2 text-sm leading-4 text-gray-400 border rounded-md"
                    v-html="link.label"
                />
                <Link
                    v-else
                    class="mr-1 px-4 py-2 text-sm leading-4 border rounded-md hover:bg-white hover:text-gray-800 focus:border-primary focus:text-primary"
                    :class="{ 'bg-blue-700 text-white': link.active }"
                    :href="link.url"
                >
                    {{ link.label }}
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/vue3";
export default defineComponent({
    components: {
        Link,
    },
    props: {
        links: Array,
    },
});
</script>
