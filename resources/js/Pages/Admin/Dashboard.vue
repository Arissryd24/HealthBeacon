<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    totalUsers: Number,
    totalPatients: Number,
    activeAlerts: Number,
    totalThresholds: Number,
    recentActivity: Array,
});

const stats = [
    {
        label: 'Total User',
        value: props.totalUsers,
        icon: '👥',
        color: 'bg-blue-500',
    },
    {
        label: 'Total Pasien',
        value: props.totalPatients,
        icon: '🏥',
        color: 'bg-green-500',
    },
    {
        label: 'Active Alerts',
        value: props.activeAlerts,
        icon: '🚨',
        color: 'bg-red-500',
    },
    {
        label: 'Threshold Configs',
        value: props.totalThresholds,
        icon: '⚙️',
        color: 'bg-purple-500',
    },
];

const formatDate = (date) => new Date(date).toLocaleString('id-ID');
</script>

<template>
    <AdminLayout>
        <Head title="Admin Dashboard" />
        <template #header>
            <h2 class="text-2xl font-semibold text-gray-800">Admin Dashboard</h2>
            <p class="text-gray-500 text-sm mt-1">Selamat datang di panel administrasi HealthBeacon</p>
        </template>

        <div class="p-4 sm:p-6 lg:p-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    v-for="stat in stats"
                    :key="stat.label"
                    class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">{{ stat.label }}</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">
                                {{ stat.value }}
                            </p>
                        </div>
                        <div :class="[stat.color, 'p-3 rounded-lg text-2xl']">
                            {{ stat.icon }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6 col-span-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a
                            href="/admin/users/create"
                            class="block px-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors text-center"
                        >
                            + Tambah User
                        </a>
                        <a
                            href="/admin/users"
                            class="block px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-center"
                        >
                            Kelola User
                        </a>
                        <a
                            href="/admin/thresholds"
                            class="block px-4 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-center"
                        >
                            Atur Threshold
                        </a>
                        <a
                            href="/admin/activity-logs"
                            class="block px-4 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-center"
                        >
                            Lihat Log Aktivitas
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow p-6 col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-3 max-h-80 overflow-y-auto">
                        <div
                            v-if="recentActivity.length > 0"
                            v-for="log in recentActivity"
                            :key="log.id"
                            class="flex items-start p-3 bg-gray-50 rounded-lg"
                        >
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ log.user?.name }} ({{ log.user?.role }})
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ log.action }}
                                </p>
                                <p class="text-xs text-gray-400 mt-2">
                                    {{ formatDate(log.created_at) }}
                                </p>
                            </div>
                            <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded">
                                {{ log.ip_address }}
                            </span>
                        </div>
                        <div v-else class="text-center py-8 text-gray-400">
                            Belum ada aktivitas
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Sistem</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500">Status</p>
                        <p class="text-green-600 font-semibold mt-1">✓ Online</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Version</p>
                        <p class="text-gray-900 font-semibold mt-1">1.0.0</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Last Update</p>
                        <p class="text-gray-900 font-semibold mt-1">Today</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Environment</p>
                        <p class="text-gray-900 font-semibold mt-1">Production</p>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
