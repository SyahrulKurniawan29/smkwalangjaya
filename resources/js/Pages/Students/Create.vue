<template>
  <app-layout>
    <h1 class="text-xl font-bold mb-4">Tambah/Edit Siswa</h1>
    <form @submit.prevent="submit">
      <div>
        <label>NIS</label>
        <input v-model="form.nis" />
      </div>
      <div>
        <label>Nama</label>
        <input v-model="form.name" />
      </div>
      <div>
        <label>Kelas</label>
        <select v-model="form.classroom_id">
          <option v-for="c in classes" :value="c.id">{{ c.name }}</option>
        </select>
      </div>
      <div class="mt-4">
        <button class="btn">Simpan</button>
      </div>
    </form>
  </app-layout>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '../Layout/AppLayout.vue'
export default {
  props: {
    student: { default: null },
    classes: Array
  },
  components: { AppLayout },
  data() {
    return { form: { nis: this.student?.nis || '', name: this.student?.name || '', classroom_id: this.student?.classroom_id || (this.classes[0]?.id || null) } }
  },
  methods: {
    submit() {
      if (this.student) {
        Inertia.put(`/students/${this.student.id}`, this.form)
      } else {
        Inertia.post('/students', this.form)
      }
    }
  }
}
</script>
