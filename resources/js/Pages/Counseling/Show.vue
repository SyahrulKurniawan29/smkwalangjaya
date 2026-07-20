<template>
  <app-layout>
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-xl font-bold">Sesi Konseling</h1>
    </div>

    <div class="mb-4">
      <h2 class="font-bold">Siswa: {{ session.student.name }}</h2>
      <div>Jadwal: {{ session.scheduled_at }}</div>
      <div>Jenis: {{ session.session_type }}</div>
      <div>Privacy: {{ session.privacy_level }}</div>
    </div>

    <div class="mb-6">
      <h3 class="font-bold">Catatan</h3>
      <div v-for="note in session.notes" :key="note.id" class="p-3 border mb-2">
        <div class="text-sm text-gray-600">oleh: {{ note.created_by }} | confidential: {{ note.confidential }}</div>
        <div class="mt-2">{{ note.note_text }}</div>
        <div v-if="note.attachments?.length">
          <h4 class="mt-2 font-semibold">Lampiran</h4>
          <ul>
            <li v-for="a in note.attachments" :key="a.id"><a :href="`/storage/${a.file_path}`" target="_blank">Lihat</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div>
      <h3 class="font-bold mb-2">Tambah Catatan</h3>
      <form ref="noteForm" @submit.prevent="submitNote" enctype="multipart/form-data">
        <div class="mb-2">
          <textarea v-model="form.note_text" placeholder="Tulis catatan..."></textarea>
        </div>
        <div class="mb-2">
          <label>Lampiran</label>
          <input type="file" ref="file" />
        </div>
        <div class="mb-2">
          <label>Confidential</label>
          <input type="checkbox" v-model="form.confidential" />
        </div>
        <div>
          <button class="btn">Simpan Catatan</button>
        </div>
      </form>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '../Layout/AppLayout.vue'
import axios from 'axios'
export default {
  components: { AppLayout },
  props: { session: Object },
  data() {
    return { form: { note_text: '', confidential: true } }
  },
  methods: {
    async submitNote() {
      const fd = new FormData()
      fd.append('note_text', this.form.note_text)
      fd.append('confidential', this.form.confidential)
      const fileInput = this.$refs.file
      if (fileInput && fileInput.files && fileInput.files[0]) {
        fd.append('attachment', fileInput.files[0])
      }

      await axios.post(`/counseling/${this.session.id}/notes`, fd, { headers: { 'Content-Type': 'multipart/form-data' } })
      window.location.reload()
    }
  }
}
</script>
