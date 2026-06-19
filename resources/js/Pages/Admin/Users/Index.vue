<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({ users: Array });

const roleBadge = {
    admin:   'bg-red-100 text-red-800',
    dokter:  'bg-blue-100 text-blue-800',
    perawat: 'bg-green-100 text-green-800',
};

const hapus = (user) => {
    if (confirm(`Hapus user ${user.name}?`)) {
        router.delete(route('admin.users.destroy', user.id));
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Manajemen User" />
        <template #header>
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Manajemen User</h2>
                    <p class="text-gray-500 text-sm mt-1">{{ users.length }} user terdaftar</p>
                </div>
                <Link :href="route('admin.users.create')"
                      class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition-colors">
                    + Tambah User
                </Link>
            </div>
        </template>

        <div class="p-4 sm:p-6 lg:p-8">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Role</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="user in users" :key="user.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 font-medium">{{ user.name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ user.email }}</td>
                            <td class="px-4 py-3">
                                <span :class="`px-2 py-1 rounded text-xs font-medium ${roleBadge[user.role]}`">
                                    {{ user.role }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <span :class="`px-2 py-1 rounded text-xs ${user.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'}`">
                                    {{ user.is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-3">
                                    <Link :href="route('admin.users.edit', user.id)"
                                          class="text-indigo-600 hover:text-indigo-900 transition-colors">Edit</Link>
                                    <button @click="hapus(user)"
                                            class="text-red-500 hover:text-red-700 transition-colors">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="users.length === 0">
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada user</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>