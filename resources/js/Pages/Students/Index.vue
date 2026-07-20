<template>
  <app-layout>
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-xl font-bold">Daftar Siswa</h1>
      <inertia-link href="/students/create" class="btn">Tambah Siswa</inertia-link>
    </div>

    <table class="min-w-full bg-white">
      <thead>
        <tr>
          <th class="px-4 py-2">NIS</th>
          <th class="px-4 py-2">Nama</th>
          <th class="px-4 py-2">Kelas</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="s in students.data" :key="s.id">
          <td class="border px-4 py-2">{{ s.nis }}</td>
          <td class="border px-4 py-2">{{ s.name }}</td>
          <td class="border px-4 py-2">{{ s.classroom?.name }}</td>
        </tr>
      </tbody>
    </table>
  </app-layout>
</template>

<script>
import AppLayout from '../Layout/AppLayout.vue'
export default {
  props: {
    students: Object,
    classes: Array
  },
  components: { AppLayout }
}
</script>
