<template>
  <app-layout>
    <div class="flex items-center justify-between mb-4">
      <h1 class="text-xl font-bold">Daftar Kelas</h1>
      <inertia-link href="/classes/create" class="btn">Buat Kelas</inertia-link>
    </div>

    <table class="min-w-full bg-white">
      <thead>
        <tr>
          <th class="px-4 py-2">Nama</th>
          <th class="px-4 py-2">Grade</th>
          <th class="px-4 py-2">Jumlah Siswa</th>
          <th class="px-4 py-2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="c in classes.data" :key="c.id">
          <td class="border px-4 py-2">{{ c.name }}</td>
          <td class="border px-4 py-2">{{ c.grade }}</td>
          <td class="border px-4 py-2">{{ c.students_count }}</td>
          <td class="border px-4 py-2">
            <inertia-link :href="`/classes/${c.id}/edit`" class="text-blue-600">Edit</inertia-link>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="mt-4">
      <pagination v-if="classes.meta" :links="classes.links" />
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../Layout/AppLayout.vue'
export default {
  props: {
    classes: Object
  },
  components: { AppLayout }
}
</script>
