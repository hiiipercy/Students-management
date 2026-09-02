<script setup>
import { Link } from '@inertiajs/vue3'; 

defineProps({
    students: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <!-- Pagination Wrapper -->
    <div v-if="students.meta && students.meta.links && students.meta.links.length >= 3" class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <!-- Links Container -->
        <div class="flex flex-wrap items-center gap-1">
            <template v-for="(link, key) in students.meta.links" :key="key">
                
                <!-- Disabled / Non-clickable state (e.g. "..." or inactive arrows) -->
                <div
                    v-if="link.url === null"
                    v-html="link.label"
                    class="px-3 py-1.5 text-sm text-gray-400 bg-white border border-gray-200 rounded-md cursor-not-allowed select-none"
                />

                <!-- Active / Clickable Page Link -->
                <Link
                    v-else
                    :href="link.url"
                    preserve-scroll 
                    v-html="link.label"
                    class="px-3 py-1.5 text-sm border rounded-md transition-colors duration-150"
                    :class="{
                        'bg-indigo-600 text-white border-indigo-600 font-semibold shadow-sm': link.active,
                        'bg-white text-gray-700 border-gray-300 hover:bg-gray-50': !link.active
                    }"
                />
            </template>
        </div>

        <!-- Results Count Info -->
        <div class="text-sm text-gray-600">
            Showing <span class="font-medium text-gray-900">{{ students.meta.from || 0 }}</span> 
            to <span class="font-medium text-gray-900">{{ students.meta.to || 0 }}</span> 
            of <span class="font-medium text-gray-900">{{ students.meta.total }}</span> results
        </div>
    </div>
</template>