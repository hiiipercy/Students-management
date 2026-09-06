<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';

defineProps({
    classes: { type: Object, required: true },
    student: { type: Object, required: true },
});

const sections = ref([]);
const students = usePage().props.student.data;


const form = useForm({
    name: students.name,
    email: students.email,
    class_id: students.class.id,
    section_id: students.section.id,
});



 // Fetch sections for the selected class when the component is mounted
onMounted(() => {
    if (form.class_id) {
        getSections(form.class_id);
    }
});

const getSections = (classId) => {
    axios.get('/api/sections', { params: { class_id: classId } })
        .then((response) => {
            sections.value = response.data;
        })
        .catch(error => {
            console.error('Error fetching sections:', error);
            sections.value = [];
        });
};

watch(() => form.class_id, (newValue) => {
    form.section_id = '';
    if (newValue) getSections(newValue);
});

const updateStudent = () => {
    form.put(route('students.update', students.id), {
        onSuccess: () => {
            form.reset();
            // Optionally, you can redirect or show a success message here
        },
    });
};
</script>


<template>
    <Head title="Add New Student" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update Student</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="updateStudent" class="space-y-6">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input 
                                v-model="form.name" 
                                type="text" 
                                id="name" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                :class="{ 'border-red-500': form.errors.name }"
                                required 
                            />
                            <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input 
                                v-model="form.email" 
                                type="email" 
                                id="email" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                :class="{ 'border-red-500': form.errors.email }"
                                required 
                            />
                            <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Class Dropdown -->
                            <div>
                                <label for="class_id" class="block text-sm font-medium text-gray-700">Class</label>
                                <select 
                                    v-model="form.class_id" 
                                    id="class_id" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    :class="{ 'border-red-500': form.errors.class_id }"
                                    required
                                >
                                    <option value="" disabled>Select Class</option>
                                    <option v-for="cls in classes.data" :key="cls.id" :value="cls.id">
                                        {{ cls.name }}
                                    </option>
                                </select>
                                <div v-if="form.errors.class_id" class="text-red-500 text-xs mt-1">{{ form.errors.class_id }}</div>
                            </div>

                            <!-- Section Dropdown -->
                            <div>
                                <label for="section_id" class="block text-sm font-medium text-gray-700">Section</label>
                                <select 
                                    v-model="form.section_id" 
                                    id="section_id" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    :class="{ 'border-red-500': form.errors.section_id }"
                                    required
                                >
                                    <option value="" disabled>Select Section</option>
                                    <option v-for="sec in sections.data" :key="sec.id" :value="sec.id">
                                        {{ sec.name }}
                                    </option>

                                </select>
                                <div v-if="form.errors.section_id" class="text-red-500 text-xs mt-1">{{ form.errors.section_id }}</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4 border-t pt-6">
                            <Link href="/students" class="text-sm text-gray-600 hover:text-gray-900">Cancel</Link>
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 disabled:opacity-50"
                            >
                                {{ form.processing ? 'Updating...' : 'Update Student' }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>