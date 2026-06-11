<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    patients: Array,
});

const statusColor = (status) => {
    if (status === 'critical') return 'bg-red-100 text-red-700 border-red-200';
    if (status === 'warning') return 'bg-yellow-100 text-yellow-700 border-yellow-200';
    return 'bg-green-100 text-green-700 border-green-200';
};

const statusDot = (status) => {
    if (status === 'critical') return 'bg-red-500';
    if (status === 'warning') return 'bg-yellow-500';
    return 'bg-green-500';
};
</script>

<template>
    <Head title="Pasien" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800">Daftar Pasien</h2>
        </template>

        <div class="py-6 px-4 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="patient in patients" :key="patient.id"
                    class="bg-white rounded-xl shadow p-5 border-l-4"
                    :class="{
                        'border-red-500': patient.status === 'critical',
                        'border-yellow-500': patient.status === 'warning',
                        'border-green-500': patient.status === 'stable',
                    }">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ patient.name }}</h3>
                            <p class="text-sm text-gray-500">Ruang {{ patient.room_number }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full border font-medium capitalize"
                            :class="statusColor(patient.status)">
                            <span class="inline-block w-2 h-2 rounded-full mr-1" :class="statusDot(patient.status)"></span>
                            {{ patient.status }}
                        </span>
                    </div>

                    <div class="text-sm text-gray-600 space-y-1 mb-4">
                        <p>👨‍⚕️ {{ patient.doctor_name }}</p>
                        <p>🎂 {{ patient.age }} tahun · {{ patient.gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        <p>🔔 {{ patient.alerts_count }} alert aktif</p>
                    </div>

                    <Link :href="route('patients.show', patient.id)"
                        class="block text-center text-sm bg-blue-600 text-white rounded-lg py-2 hover:bg-blue-700 transition">
                        Lihat Detail & Vital Signs
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>