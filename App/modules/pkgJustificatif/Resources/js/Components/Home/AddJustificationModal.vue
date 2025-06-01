<template>
  <div
    v-if="show"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full">
      <h2 class="text-xl font-semibold mb-4">Titre du Modal</h2>
      <p class="mb-4">Ceci est le contenu du modal.</p>
      <button
        @click="$emit('close')"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
      >
        Fermer
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps(['show'])
</script>
