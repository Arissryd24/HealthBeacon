<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

const props = defineProps({
    alerts: Object,
});

const severityColor = (severity) => {
    if (severity === 'critical') return 'bg-red-100 text-red-700 border-red-300';
    if (severity === 'medium') return 'bg-yellow-100 text-yellow-700 border-yellow-300';
    return 'bg-blue-100 text-blue-700 border-blue-300';
};

const severityBadge = (severity) => {
    if (severity === 'critical') return 'bg-red-500 text-white';
    if (severity === 'medium') return 'bg-yellow-500 text-white';
    return 'bg-blue-500 text-white';
};

const resolve = (id) => {
    router.patch(route('alerts.resolve', id));
};
</script>

<template>
    <Head title="Alerts" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">⚠️ Alert Log — Aktivitas Agen</h2>
        </template>

        <div class="py-6 px-4 max-w-5xl mx-auto space-y-4">

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
                🤖 Halaman ini menampilkan semua alert yang dibuat otomatis oleh <strong>HealthBeacon Agent</strong> berdasarkan tren data vital pasien.
            </div>

            <div v-if="alerts.data.length === 0" class="bg-white rounded-xl shadow p-8 text-center text-gray-400">
                Tidak ada alert yang tercatat.
            </div>

            <div v-for="alert in alerts.data" :key="alert.id"
                class="bg-white rounded-xl shadow p-5 border-l-4"
                :class="{
                    'border-red-500': alert.severity === 'critical',
                    'border-yellow-500': alert.severity === 'medium',
                    'border-blue-500': alert.severity === 'low',
                }">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-2">
                        <span class="text-xs px-2 py-1 rounded-full font-medium" :class="severityBadge(alert.severity)">
                            {{ alert.severity.toUpperCase() }}
                        </span>
                        <p class="font-semibold text-gray-800">{{ alert.alert_type }}</p>
                    </div>
                    <span class="text-xs text-gray-400">
                        {{ new Date(alert.triggered_at).toLocaleString('id-ID') }}
                    </span>
                </div>

                <p class="text-sm text-gray-600 mt-2">{{ alert.message }}</p>

                <div class="flex justify-between items-center mt-3">
                    <Link :href="route('patients.show', alert.patient_id)"
                        class="text-sm text-blue-600 hover:underline">
                        👤 {{ alert.patient?.name }} — Ruang {{ alert.patient?.room_number }}
                    </Link>

                    <div class="flex items-center gap-2">
                        <span v-if="!alert.is_active" class="text-xs text-green-600 font-medium">✓ Resolved</span>
                        <button v-else @click="resolve(alert.id)"
                            class="text-xs bg-green-600 text-white px-3 py-1 rounded-lg hover:bg-green-700 transition">
                            Tandai Resolved
                        </button>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center gap-2 pt-2">
                <Link v-for="link in alerts.links" :key="link.label"
                    :href="link.url ?? '#'"
                    class="px-3 py-1 text-sm rounded border"
                    :class="link.active ? 'bg-blue-600 text-white border-blue-600' : 'text-gray-600 hover:bg-gray-50'"
                    v-html="link.label" />
            </div>

        </div>
    </AuthenticatedLayout>
</template>