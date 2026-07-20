<template>
  <app-layout>
    <h1 class="text-xl font-bold mb-4">Buat/Edit Kelas</h1>
    <form method="post" @submit.prevent="submit">
      <div>
        <label>Nama</label>
        <input v-model="form.name" />
      </div>
      <div>
        <label>Grade</label>
        <input v-model="form.grade" />
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
    classroom: { default: null }
  },
  components: { AppLayout },
  data() {
    return { form: { name: this.classroom?.name || '', grade: this.classroom?.grade || '' } }
  },
  methods: {
    submit() {
      if (this.classroom) {
        Inertia.put(`/classes/${this.classroom.id}`, this.form)
      } else {
        Inertia.post('/classes', this.form)
      }
    }
  }
}
</script>
