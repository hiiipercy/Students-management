<script setup>
import MagnifyingGlass from '@/Components/Icons/MagnifyingGlass.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3'; 
import Pagination from '@/Components/Pagination.vue';
import { ref, computed } from 'vue';

// Receive the students prop from your Laravel Controller
const props = defineProps({
    students: {
        type: Object,
        required: true
    }
});

// Define search query ref
const searchQuery = ref('');

// Filter students locally based on the search query ref
const filteredStudents = computed(() => {
    if (!searchQuery.value) {
        return props.students.data;
    }
    
    const query = searchQuery.value.toLowerCase();
    return props.students.data.filter(student => 
        student.name.toLowerCase().includes(query) ||
        student.email.toLowerCase().includes(query) ||
        (student.class?.name && student.class.name.toLowerCase().includes(query)) ||
        (student.section?.name && student.section.name.toLowerCase().includes(query))
    );
});

// Delete function
const deleteStudent = (id) => {
    if (confirm('Are you sure you want to delete this student?')) {
        router.delete(route('students.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Students Management" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students List</h2>
                <Link :href="route('students.create')" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Add Student</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <!-- Search / Filter Bar with MagnifyingGlass Icon -->
                        <div class="mb-6 flex items-center justify-between">
                            <div class="relative w-full max-w-sm">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                                    <MagnifyingGlass class="w-5 h-5" />
                                </span>
                                <input 
                                    v-model="searchQuery"
                                    type="text" 
                                    placeholder="Search students..." 
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                />
                            </div>
                        </div>
                        
                        <!-- Students Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                        <th scope="col" class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Loop through filteredStudents instead of students.data -->
                                    <tr v-for="student in filteredStudents" :key="student.id" class="hover:bg-gray-50">
                                        <!-- SL -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ student.id }}
                                        </td>

                                        <!-- Name -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ student.name }}
                                        </td>
                                        
                                        <!-- Email -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ student.email }}
                                        </td>
                                        
                                        <!-- Class Badge -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ student.class?.name || 'N/A' }}
                                            </span>
                                        </td>
                                        
                                        <!-- Section Badge -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ student.section?.name || 'N/A' }}
                                            </span>
                                        </td>

                                        <!-- Created At -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ student.created_at }}
                                        </td>
                                        
                                        <!-- Actions (Edit & Delete) -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                            <Link :href="route('students.edit', student.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                            
                                            <button 
                                                @click="deleteStudent(student.id)" 
                                                class="text-red-600 hover:text-red-900 bg-transparent border-none cursor-pointer"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Empty State -->
                                    <tr v-if="filteredStudents.length === 0">
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No students found.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-4">
                            <Pagination :students="students" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>