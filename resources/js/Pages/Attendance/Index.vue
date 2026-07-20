<template>
  <app-layout>
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-xl font-bold">Absensi</h1>
      <inertia-link href="/attendance" class="btn">Refresh</inertia-link>
    </div>

    <div class="mb-4">
      <label>Kelas</label>
      <select v-model="selectedClassId" @change="loadAttendances">
        <option v-for="c in classList" :value="c.id">{{ c.name }}</option>
      </select>

      <label class="ml-4">Dari</label>
      <input type="date" v-model="from" @change="loadAttendances" />
      <label class="ml-2">Sampai</label>
      <input type="date" v-model="to" @change="loadAttendances" />

      <inertia-link :href="`/attendance/${selectedClassId}?from=${from}&to=${to}`" class="btn ml-4">Tampilkan</inertia-link>
      <inertia-link :href="`/attendance/create?class_id=${selectedClassId}`" class="btn ml-2">Isi Absensi</inertia-link>
    </div>

    <table class="min-w-full bg-white">
      <thead>
        <tr>
          <th class="px-4 py-2">Tanggal</th>
          <th class="px-4 py-2">Siswa</th>
          <th class="px-4 py-2">Status</th>
          <th class="px-4 py-2">Catatan</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="a in attendances.data" :key="a.id">
          <td class="border px-4 py-2">{{ a.date }}</td>
          <td class="border px-4 py-2">{{ a.student.name }}</td>
          <td class="border px-4 py-2">{{ a.status }}</td>
          <td class="border px-4 py-2">{{ a.note }}</td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4">
      <pagination v-if="attendances.meta" :links="attendances.links" />
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../Layout/AppLayout.vue'
export default {
  components: { AppLayout },
  props: {
    attendances: Object,
    classList: Array
  },
  data() {
    return {
      selectedClassId: this.classList[0]?.id || null,
      from: new Date().toISOString().substr(0,10),
      to: new Date().toISOString().substr(0,10),
    }
  },
  methods: {
    loadAttendances() {
      // Using Inertia link to refresh handled via href; this method can be extended
    }
  }
}
</script>
