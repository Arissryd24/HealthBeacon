<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    thresholds: Array,
    patients: Array,
});

const form = useForm({
    patient_id:      '',
    heart_rate_min:  60,
    heart_rate_max:  100,
    oxygen_min:      95,
    temperature_min: 36.0,
    temperature_max: 37.5,
});

const submit = () => form.post(route('admin.thresholds.store'));
</script>

<template>
    <AdminLayout>
        <Head title="Pengaturan Threshold Alert" />
        <template #header>
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">Pengaturan Threshold Alert</h2>
                <p class="text-gray-500 text-sm mt-1">Atur nilai batas normal untuk setiap pasien</p>
            </div>
        </template>

        <div class="p-4 sm:p-6 lg:p-8 space-y-6">

            <!-- Form tambah threshold -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow">
                <h3 class="font-semibold text-gray-900 mb-4 text-lg">Tambah / Update Threshold</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pasien <span class="text-gray-400">(kosong = default semua)</span></label>
                        <select v-model="form.patient_id"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Default (semua pasien)</option>
                            <option v-for="p in patients" :key="p.id" :value="p.id">{{ p.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Detak Jantung Min</label>
                        <input v-model="form.heart_rate_min" type="number"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Detak Jantung Max</label>
                        <input v-model="form.heart_rate_max" type="number"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Saturasi O₂ Min (%)</label>
                        <input v-model="form.oxygen_min" type="number"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Suhu Min (°C)</label>
                        <input v-model="form.temperature_min" type="number" step="0.1"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"/>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Suhu Max (°C)</label>
                        <input v-model="form.temperature_max" type="number" step="0.1"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"/>
                    </div>
                </div>
                <button @click="submit" :disabled="form.processing"
                        class="mt-4 bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-indigo-700 disabled:opacity-50 transition-colors">
                    {{ form.processing ? 'Menyimpan...' : 'Simpan Threshold' }}
                </button>
            </div>

            <!-- Tabel threshold yang sudah ada -->
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Pasien</th>
                            <th class="px-4 py-3 text-left">Detak Jantung</th>
                            <th class="px-4 py-3 text-left">O₂ Min</th>
                            <th class="px-4 py-3 text-left">Suhu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr v-for="t in thresholds" :key="t.id" class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 font-medium">{{ t.patient?.name ?? 'Default' }}</td>
                            <td class="px-4 py-3">{{ t.heart_rate_min }} – {{ t.heart_rate_max }} bpm</td>
                            <td class="px-4 py-3">{{ t.oxygen_min }}%</td>
                            <td class="px-4 py-3">{{ t.temperature_min }} – {{ t.temperature_max }} °C</td>
                        </tr>
                        <tr v-if="thresholds.length === 0">
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada threshold</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AdminLayout>
</template>