<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({ logs: Object });

const formatDate = (date) => new Date(date).toLocaleString('id-ID');
</script>

<template>
    <AdminLayout>
        <Head title="Log Aktivitas" />
        <template #header>
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Log Aktivitas</h2>
                <p class="text-gray-500 text-sm mt-1">Riwayat aktivitas semua pengguna dalam sistem</p>
            </div>
        </template>

        <div class="p-4 sm:p-6 lg:p-8">
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Waktu</th>
                            <th class="px-4 py-3 text-left">User</th>
                            <th class="px-4 py-3 text-left">Role</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                            <th class="px-4 py-3 text-left">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="log in logs.data" :key="log.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-600 whitespace-nowrap text-xs">{{ formatDate(log.created_at) }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ log.user?.name }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-medium">
                                    {{ log.user?.role }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-700">{{ log.action }}</td>
                            <td class="px-4 py-3 text-gray-400 font-mono text-xs">{{ log.ip_address }}</td>
                        </tr>
                        <tr v-if="logs.data.length === 0">
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada log aktivitas</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="logs.links" class="mt-4 flex justify-center gap-2">
                <a
                    v-for="link in logs.links"
                    :key="link.label"
                    :href="link.url"
                    :class="[
                        'px-3 py-2 rounded-lg text-sm',
                        link.active
                            ? 'bg-indigo-600 text-white'
                            : link.url
                            ? 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'
                            : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </AdminLayout>
</template>