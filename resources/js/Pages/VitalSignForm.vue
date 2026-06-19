<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Input Vital Sign Pasien</h2>
    </template>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white font-weight-bold">
              Form Input Vital Sign (Test Agen)
            </div>
            <div class="card-body">
              
              <form @submit.prevent="submitForm">
                
                <div class="mb-3 text-start">
                  <label class="form-label font-weight-bold text-dark">Pilih Pasien</label>
                  <select v-model="form.patient_id" class="form-select" required>
                    <option value="">-- Pilih Pasien --</option>
                    <option v-for="patient in patients" :key="patient.id" :value="patient.id">
                      {{ patient.name }}
                    </option>
                  </select>
                </div>

                <div class="mb-3 text-start">
                  <label class="form-label font-weight-bold text-dark">Saturasi Oksigen (SpO2 %)</label>
                  <input type="number" v-model="form.spo2" class="form-control" placeholder="Contoh: 98" required>
                </div>

                <div class="mb-3 text-start">
                  <label class="form-label font-weight-bold text-dark">Detak Jantung (Heart Rate - bpm)</label>
                  <input type="number" v-model="form.heart_rate" class="form-control" placeholder="Contoh: 80" required>
                </div>

                <div class="mb-3 text-start">
                  <label class="form-label font-weight-bold text-dark">Suhu Tubuh (°C)</label>
                  <input type="number" step="0.1" v-model="form.temperature" class="form-control" placeholder="Contoh: 36.5" required>
                </div>

                <div class="row mb-4 text-start">
                  <div class="col">
                    <label class="form-label font-weight-bold text-dark">Sistolik (BP)</label>
                    <input type="number" v-model="form.systolic_bp" class="form-control" placeholder="120" required>
                  </div>
                  <div class="col">
                    <label class="form-label font-weight-bold text-dark">Diastolik (BP)</label>
                    <input type="number" v-model="form.diastolic_bp" class="form-control" placeholder="80" required>
                  </div>
                </div>

                <div class="d-grid gap-2 text-end">
                  <button type="submit" :disabled="form.processing" class="btn btn-success btn-lg fw-bold">
                    {{ form.processing ? 'Memproses...' : 'Simpan & Trigger Agen' }}
                  </button>
                </div>

              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
  patients: Array
});

const form = useForm({
  patient_id: '',
  spo2: 98,
  heart_rate: 80,
  temperature: 36.5,
  systolic_bp: 120,
  diastolic_bp: 80,
});

const submitForm = () => {
  form.post(route('vitalsigns.store'));
};
</script>