W<template>
  <transition name="fade">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h3 class="text-xl font-semibold mb-4">{{ isEditMode ? 'Modifier Absence' : 'Ajouter Absence' }}</h3>

        <form @submit.prevent="submitForm">
          <!-- Apprenant -->
          <label class="block mb-2 font-medium">Apprenant</label>
          <select v-model="form.apprenant_id" class="w-full border rounded px-3 py-2 mb-4" required>
            <option value="" disabled>Choisir un apprenant</option>
            <option v-for="a in apprenants" :key="a.id" :value="a.id">
              {{ a.nom }} {{ a.prenom }}
            </option>
          </select>

          <!-- Séance -->
          <label class="block mb-2 font-medium">Séance</label>
          <select v-model="form.seance_id" class="w-full border rounded px-3 py-2 mb-4" required>
            <option value="" disabled>Choisir une séance</option>
            <option v-for="s in seances" :key="s.id" :value="s.id">
              {{ new Date(s.date_debut).toLocaleDateString() }} - {{ new Date(s.date_debut).toLocaleTimeString() }}
            </option>
          </select>

          <!-- Justifié -->
          <label class="inline-flex items-center mb-4">
            <input type="checkbox" v-model="form.justifie" class="form-checkbox" />
            <span class="ml-2">Justifié</span>
          </label>

          <!-- Est sanctionnée -->
          <label class="inline-flex items-center mb-4">
            <input type="checkbox" v-model="form.est_sanctionnée" class="form-checkbox" />
            <span class="ml-2">Est sanctionnée</span>
          </label>

          <!-- Buttons -->
          <div class="flex justify-end space-x-2">
            <button type="button" @click="close" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">
              Annuler
            </button>
            <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
              {{ isEditMode ? 'Mettre à jour' : 'Ajouter' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, watch, computed } from 'vue';

// Props
defineProps({
  show: Boolean,
  initialData: {
    type: Object,
    default: () => ({
      apprenant_id: '',
      seance_id: '',
      justifie: false,
      est_sanctionnée: false,
    }),
  },
  apprenants: Array,
  seances: Array,
});

// Emits
const emit = defineEmits(['close', 'submit']);

// Reactive form data
const form = ref({ ...initialData });

// Watch for changes on initialData (when editing)
watch(
  () => initialData,
  (newVal) => {
    form.value = { ...newVal };
  },
  { deep: true, immediate: true }
);

const isEditMode = computed(() => !!initialData && !!initialData.id);

function submitForm() {
  emit('submit', form.value);
}

function close() {
  emit('close');
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.25s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
