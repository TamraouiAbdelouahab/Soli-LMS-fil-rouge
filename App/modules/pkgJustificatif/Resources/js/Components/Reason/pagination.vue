<template>
    <!-- <div class="flex flex-wrap items-center space-x-1 mt-4">
        <Link
            v-for="(link,index) in props.Links"
            :key="index"
            :href="link.url || '#'"
            class="px-3 py-1 text-sm rounded border"
            :class="[
                link.active
                    ? 'bg-blue-600 text-white'
                    : 'text-gray-600 hover:text-gray-700 hover:bg-gray-200',
                link.url
                    ? 'opacity-75 pointer-events-none'
                    : 'hover:bg-gray-100',
            ]"
            >
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                {{ link.label }}
            </button>
        </Link>
    </div> -->
    <nav class="flex items-center justify-center gap-2 mt-4">
        <template v-for="(link, index) in Links" :key="index">
        <span
            v-if="!link.url"
            class="px-3 py-1 text-gray-400 border rounded cursor-not-allowed"
            v-html="link.label"
        ></span>
        <a
            v-else
            :href="link.url"
            class="px-3 py-1 border rounded"
            :class="{
            'bg-blue-500 text-white': link.active,
            'hover:bg-gray-100': !link.active
            }"
            v-html="(link.label == 'Next »') ? '»»' : link.label"
        ></a>
        </template>
    </nav>


</template>




<script setup>
import {Link} from '@inertiajs/vue3'
const props = defineProps({
    Links:Array,
})


</script>
