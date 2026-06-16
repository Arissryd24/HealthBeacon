<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import VueApexCharts from 'vue3-apexcharts';

const props = defineProps({
    stats: Object,
    recentAlerts: Array,
    patients: Array,
});

const severityColor = (severity) => {
    if (severity === 'critical') return 'bg-red-100 text-red-700 border-red-300';
    if (severity === 'medium') return 'bg-yellow-100 text-yellow-700 border-yellow-300';
    return 'bg-blue-100 text-blue-700 border-blue-300';
};

const statusColor = (status) => {
    if (status === 'critical') return 'bg-red-500';
    if (status === 'warning') return 'bg-yellow-500';
    return 'bg-green-500';
};

const donutSeries = [props.stats.critical, props.stats.warning, props.stats.stable];
const donutOptions = {
    chart: { type: 'donut' },
    labels: ['Critical', 'Warning', 'Stable'],
    colors: ['#ef4444', '#f59e0b', '#22c55e'],
    legend: { position: 'bottom' },
};
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">HealthBeacon — Dashboard</h2>
        </template>

        <div class="py-6 px-4 max-w-7xl mx-auto space-y-6">

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <p class="text-sm text-gray-500">Total Pasien</p>
                    <p class="text-3xl font-bold text-gray-800">{{ stats.total }}</p>
                </div>
                <div class="bg-red-50 rounded-xl shadow p-4 text-center border border-red-200">
                    <p class="text-sm text-red-500">Critical</p>
                    <p class="text-3xl font-bold text-red-600">{{ stats.critical }}</p>
                </div>
                <div class="bg-yellow-50 rounded-xl shadow p-4 text-center border border-yellow-200">
                    <p class="text-sm text-yellow-500">Warning</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ stats.warning }}</p>
                </div>
                <div class="bg-green-50 rounded-xl shadow p-4 text-center border border-green-200">
                    <p class="text-sm text-green-500">Stable</p>
                    <p class="text-3xl font-bold text-green-600">{{ stats.stable }}</p>
                </div>
                <div class="bg-purple-50 rounded-xl shadow p-4 text-center border border-purple-200">
                    <p class="text-sm text-purple-500">Active Alerts</p>
                    <p class="text-3xl font-bold text-purple-600">{{ stats.alerts }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Donut Chart -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">Status Pasien</h3>
                    <VueApexCharts type="donut" :options="donutOptions" :series="donutSeries" height="280" />
                </div>

                <!-- Recent Alerts -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-semibold text-gray-700 mb-4">⚠️ Alert Aktif Terbaru</h3>
                    <div v-if="recentAlerts.length === 0" class="text-gray-400 text-sm">Tidak ada alert aktif.</div>
                    <div v-for="alert in recentAlerts" :key="alert.id"
                        class="mb-3 p-3 rounded-lg border text-sm"
                        :class="severityColor(alert.severity)">
                        <p class="font-semibold">{{ alert.patient?.name }} — {{ alert.alert_type }}</p>
                        <p class="text-xs mt-1 opacity-80">{{ alert.message }}</p>
                    </div>
                </div>
            </div>

            <!-- Patient List -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-700">Daftar Pasien</h3>
                    <Link :href="route('patients.index')" class="text-sm text-blue-600 hover:underline">Lihat Semua →</Link>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500 border-b">
                            <tr>
                                <th class="pb-2">Nama</th>
                                <th class="pb-2">Ruangan</th>
                                <th class="pb-2">Dokter</th>
                                <th class="pb-2">Status</th>
                                <th class="pb-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="patient in patients" :key="patient.id" class="border-b last:border-0">
                                <td class="py-2 font-medium">{{ patient.name }}</td>
                                <td class="py-2">{{ patient.room_number }}</td>
                                <td class="py-2">{{ patient.doctor_name }}</td>
                                <td class="py-2">
                                    <span class="inline-flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full" :class="statusColor(patient.status)"></span>
                                        <span class="capitalize">{{ patient.status }}</span>
                                    </span>
                                </td>
                                <td class="py-2">
                                    <Link :href="route('patients.show', patient.id)" class="text-blue-600 hover:underline">Detail</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>