<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import VueApexCharts from 'vue3-apexcharts';
import { computed } from 'vue';

const props = defineProps({
    patient: Object,
    vitalSigns: Array,
    alerts: Array,
});

const categories = computed(() =>
    props.vitalSigns.map(v => {
        const d = new Date(v.recorded_at);
        return `${d.getHours()}:${String(d.getMinutes()).padStart(2, '0')}`;
    })
);

const chartOptions = (title, color) => ({
    chart: { type: 'line', toolbar: { show: false }, animations: { enabled: true } },
    stroke: { curve: 'smooth', width: 2 },
    colors: [color],
    xaxis: { categories: categories.value, labels: { rotate: -45, style: { fontSize: '10px' } } },
    title: { text: title, style: { fontSize: '13px' } },
    tooltip: { x: { show: true } },
});

const heartRateSeries = computed(() => [{
    name: 'Heart Rate',
    data: props.vitalSigns.map(v => v.heart_rate),
}]);

const bpSeries = computed(() => [
    { name: 'Sistolik', data: props.vitalSigns.map(v => v.systolic_bp) },
    { name: 'Diastolik', data: props.vitalSigns.map(v => v.diastolic_bp) },
]);

const spo2Series = computed(() => [{
    name: 'SpO2 (%)',
    data: props.vitalSigns.map(v => v.spo2),
}]);

const tempSeries = computed(() => [{
    name: 'Suhu (°C)',
    data: props.vitalSigns.map(v => v.temperature),
}]);

const severityColor = (severity) => {
    if (severity === 'critical') return 'bg-red-100 text-red-700 border-red-300';
    if (severity === 'medium') return 'bg-yellow-100 text-yellow-700 border-yellow-300';
    return 'bg-blue-100 text-blue-700 border-blue-300';
};

const statusColor = (status) => {
    if (status === 'critical') return 'text-red-600 bg-red-50 border-red-200';
    if (status === 'warning') return 'text-yellow-600 bg-yellow-50 border-yellow-200';
    return 'text-green-600 bg-green-50 border-green-200';
};
</script>

<template>
    <Head :title="patient.name" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link :href="route('patients.index')" class="text-gray-400 hover:text-gray-600">← Kembali</Link>
                <h2 class="text-xl font-semibold text-gray-800">{{ patient.name }}</h2>
                <span class="text-xs px-3 py-1 rounded-full border font-medium capitalize"
                    :class="statusColor(patient.status)">
                    {{ patient.status }}
                </span>
            </div>
        </template>

        <div class="py-6 px-4 max-w-7xl mx-auto space-y-6">

            <!-- Info Pasien -->
            <div class="bg-white rounded-xl shadow p-6 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-gray-400">Ruangan</p>
                    <p class="font-semibold">{{ patient.room_number }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Dokter</p>
                    <p class="font-semibold">{{ patient.doctor_name }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Usia</p>
                    <p class="font-semibold">{{ patient.age }} tahun</p>
                </div>
                <div>
                    <p class="text-gray-400">Jenis Kelamin</p>
                    <p class="font-semibold">{{ patient.gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
            </div>

            <!-- Charts Vital Signs -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow p-5">
                    <VueApexCharts type="line" height="220"
                        :options="chartOptions('Detak Jantung (bpm)', '#ef4444')"
                        :series="heartRateSeries" />
                </div>
                <div class="bg-white rounded-xl shadow p-5">
                    <VueApexCharts type="line" height="220"
                        :options="{ ...chartOptions('Tekanan Darah (mmHg)', '#3b82f6'), colors: ['#ef4444', '#3b82f6'] }"
                        :series="bpSeries" />
                </div>
                <div class="bg-white rounded-xl shadow p-5">
                    <VueApexCharts type="line" height="220"
                        :options="chartOptions('SpO2 (%)', '#8b5cf6')"
                        :series="spo2Series" />
                </div>
                <div class="bg-white rounded-xl shadow p-5">
                    <VueApexCharts type="line" height="220"
                        :options="chartOptions('Suhu Tubuh (°C)', '#f59e0b')"
                        :series="tempSeries" />
                </div>
            </div>

            <!-- Alert History -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-gray-700 mb-4">🔔 Riwayat Alert Agen</h3>
                <div v-if="alerts.length === 0" class="text-gray-400 text-sm">
                    Tidak ada alert untuk pasien ini.
                </div>
                <div v-for="alert in alerts" :key="alert.id"
                    class="mb-3 p-3 rounded-lg border text-sm"
                    :class="severityColor(alert.severity)">
                    <div class="flex justify-between">
                        <p class="font-semibold">{{ alert.alert_type }}</p>
                        <span class="text-xs opacity-70">
                            {{ new Date(alert.triggered_at).toLocaleString('id-ID') }}
                        </span>
                    </div>
                    <p class="text-xs mt-1 opacity-80">{{ alert.message }}</p>
                    <span v-if="!alert.is_active" class="text-xs text-green-600 font-medium">✓ Resolved</span>
                    <span v-else class="text-xs text-red-600 font-medium">● Aktif</span>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>