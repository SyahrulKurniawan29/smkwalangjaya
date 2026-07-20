<template>
  <app-layout>
    <h1 class="text-xl font-bold mb-4">Buat Sesi Konseling</h1>
    <form @submit.prevent="submit">
      <div class="mb-2">
        <label>Siswa</label>
        <select v-model="form.student_id">
          <option v-for="s in students" :value="s.id">{{ s.name }} - {{ s.nis }}</option>
        </select>
      </div>
      <div class="mb-2">
        <label>Tanggal & Waktu</label>
        <input type="datetime-local" v-model="form.scheduled_at" />
      </div>
      <div class="mb-2">
        <label>Jenis</label>
        <select v-model="form.session_type">
          <option value="individual">Individual</option>
          <option value="group">Group</option>
        </select>
      </div>
      <div class="mb-2">
        <label>Catatan awal</label>
        <textarea v-model="form.note_text"></textarea>
      </div>
      <div class="mb-2">
        <label>Confidential</label>
        <input type="checkbox" v-model="form.confidential" />
      </div>
      <div>
        <button class="btn">Simpan</button>
      </div>
    </form>
  </app-layout>
</template>

<script>
import AppLayout from '../Layout/AppLayout.vue'
import { Inertia } from '@inertiajs/inertia'
export default {
  components: { AppLayout },
  props: { students: Array },
  data() {
    return { form: { student_id: this.students[0]?.id || null, scheduled_at: '', session_type: 'individual', note_text: '', confidential: true } }
  },
  methods: {
    submit() {
      Inertia.post('/counseling', this.form)
    }
  }
}
</script>
