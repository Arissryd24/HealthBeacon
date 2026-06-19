<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({ user: Object });

const form = useForm({
    name:      props.user.name,
    role:      props.user.role,
    is_active: props.user.is_active,
    password:  '',
});

const submit = () => form.patch(route('admin.users.update', props.user.id));
</script>

<template>
    <AdminLayout>
        <Head title="Edit User" />
        <template #header>
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Edit User</h2>
                <p class="text-gray-500 text-sm mt-1">{{ props.user.email }}</p>
            </div>
        </template>

        <div class="p-4 sm:p-6 lg:p-8">
            <div class="bg-white rounded-xl border border-gray-200 p-6 max-w-md shadow">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input v-model="form.name" type="text"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"/>
                        <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru <span class="text-gray-400 text-xs">(kosongkan jika tidak diubah)</span></label>
                        <input v-model="form.password" type="password"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"/>
                        <p v-if="form.errors.password" class="text-red-500 text-xs mt-1">{{ form.errors.password }}</p>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <input v-model="form.is_active" type="checkbox" id="is_active" class="rounded border-gray-300"/>
                        <label for="is_active" class="text-sm font-medium text-gray-700">Akun Aktif</label>
                    </div>

                    <button @click="submit" :disabled="form.processing"
                            class="w-full bg-indigo-600 text-white py-2 rounded-lg text-sm hover:bg-indigo-700 disabled:opacity-50 transition-colors mt-6">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                    </button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>