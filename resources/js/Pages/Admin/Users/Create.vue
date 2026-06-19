<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    role: 'perawat',
    password: '',
});

const submit = () => form.post(route('admin.users.store'));
</script>

<template>
    <AdminLayout>
        <Head title="Tambah User" />
        <template #header>
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Tambah User Baru</h2>
                <p class="text-gray-500 text-sm mt-1">Buat akun user untuk dokter, perawat, atau admin</p>
            </div>
        </template>

        <div class="p-4 sm:p-6 lg:p-8">
            <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-md shadow">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input v-model="form.name" type="text"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="John Doe"/>
                        <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input v-model="form.email" type="email"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="john@example.com"/>
                        <p v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input v-model="form.password" type="password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                               placeholder="Minimal 8 karakter"/>
                        <p v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <select v-model="form.role"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="perawat">Perawat</option>
                            <option value="dokter">Dokter</option>
                            <option value="admin">Admin</option>
                        </select>
                        <p v-if="form.errors.role" class="text-red-500 text-xs mt-1">{{ form.errors.role }}</p>
                    </div>

                    <button @click="submit" :disabled="form.processing"
                            class="w-full bg-indigo-600 text-white py-2 rounded-lg text-sm hover:bg-indigo-700 disabled:opacity-50 transition-colors mt-6">
                        {{ form.processing ? 'Menyimpan...' : 'Tambah User' }}
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>