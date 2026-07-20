<template>
  <app-layout>
    <h1 class="text-xl font-bold mb-4">Isi Absensi</h1>

    <div v-if="flash" class="mb-4 p-3 bg-green-100 text-green-800">{{ flash }}</div>
    <div v-if="errors.general" class="mb-4 p-3 bg-red-100 text-red-800">{{ errors.general }}</div>

    <form @submit.prevent="submit">
      <div class="mb-2">
        <label>Kelas</label>
        <select v-model="form.classroom_id" @change="loadStudents">
          <option v-for="c in classes" :value="c.id">{{ c.name }}</option>
        </select>
      </div>
      <div class="mb-2">
        <label>Tanggal</label>
        <input type="date" v-model="form.date" />
      </div>

      <table class="min-w-full bg-white mt-4">
        <thead>
          <tr>
            <th class="px-4 py-2">NIS</th>
            <th class="px-4 py-2">Nama</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Catatan</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(s, idx) in students" :key="s.id">
            <td class="border px-4 py-2">{{ s.nis }}</td>
            <td class="border px-4 py-2">{{ s.name }}</td>
            <td class="border px-4 py-2">
              <select v-model="form.records[idx].status">
                <option value="present">Hadir</option>
                <option value="sick">Sakit</option>
                <option value="permission">Izin</option>
                <option value="absent">Alfa</option>
              </select>
            </td>
            <td class="border px-4 py-2">
              <input v-model="form.records[idx].note" />
              <div v-if="errors[`records.${idx}.student_id`]
              || errors[`records.${idx}.status`]
              || errors[`records.${idx}.note`]" class="text-sm text-red-600 mt-1">
                <div v-if="errors[`records.${idx}.student_id`]">{{ errors[`records.${idx}.student_id`] }}</div>
                <div v-if="errors[`records.${idx}.status`]">{{ errors[`records.${idx}.status`] }}</div>
                <div v-if="errors[`records.${idx}.note`]">{{ errors[`records.${idx}.note`] }}</div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="mt-4">
        <button class="btn" :disabled="submitting">{{ submitting ? 'Menyimpan...' : 'Simpan Absensi' }}</button>
      </div>
    </form>
  </app-layout>
</template>

<script>
import AppLayout from '../Layout/AppLayout.vue'
import axios from 'axios'
export default {
  components: { AppLayout },
  props: { classes: Array },
  data() {
    return {
      students: [],
      form: {
        classroom_id: this.classes[0]?.id || null,
        date: new Date().toISOString().substr(0,10),
        records: []
      },
      errors: {},
      submitting: false,
      flash: null
    }
  },
  mounted() {
    if (this.form.classroom_id) this.loadStudents()
    // read flash message from server-side session (if any)
    if (pageProps && pageProps.flash && pageProps.flash.success) {
      this.flash = pageProps.flash.success
    }
  },
  methods: {
    async loadStudents() {
      try {
        const res = await axios.get(`/api/classrooms/${this.form.classroom_id}/students`)
        this.students = res.data
        this.form.records = this.students.map(s => ({ student_id: s.id, status: 'present', note: '' }))
        this.errors = {}
      } catch (e) {
        this.errors.general = 'Gagal mengambil daftar siswa.'
      }
    },
    async submit() {
      this.submitting = true
      this.errors = {}
      try {
        await axios.post('/attendance/bulk', this.form)
        window.location.href = `/attendance/${this.form.classroom_id}?from=${this.form.date}&to=${this.form.date}`
      } catch (err) {
        if (err.response && err.response.status === 422) {
          const data = err.response.data.errors || {}
          // Flatten Laravel-style errors into a simple map
          Object.keys(data).forEach(k => {
            this.errors[k] = Array.isArray(data[k]) ? data[k].join(' ') : data[k]
          })
        } else {
          this.errors.general = 'Terjadi kesalahan saat menyimpan. Coba lagi.'
        }
      } finally {
        this.submitting = false
      }
    }
  }
}
</script>
