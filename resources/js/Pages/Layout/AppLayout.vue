<template>
  <div>
    <nav class="p-4 bg-white shadow">
      <div class="max-w-7xl mx-auto">
        <a href="/dashboard" class="font-bold">SMK Walang Jaya</a>
      </div>
    </nav>
    <main class="p-6">
      <slot />
    </main>
  </div>
</template>

<script>
export default {
  name: 'AppLayout'
}
</script>

<style scoped>
</style>
