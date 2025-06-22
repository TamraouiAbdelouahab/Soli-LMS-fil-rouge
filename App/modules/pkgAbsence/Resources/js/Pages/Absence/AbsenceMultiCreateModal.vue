<template>
  <transition name="modal" appear>
    <div v-if="show" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <transition name="overlay" appear>
          <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="close"></div>
        </transition>

        <!-- Modal panel -->
        <div class="inline-block w-full max-w-4xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
          <!-- Header -->
          <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
              <div class="p-2 bg-blue-100 rounded-lg">
                <Users class="w-6 h-6 text-blue-600" />
              </div>
              <div>
                <h3 class="text-xl font-semibold text-gray-900">Absences Groupées</h3>
                <p class="text-sm text-gray-500">Enregistrer plusieurs absences simultanément</p>
              </div>
            </div>
            <button @click="close" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
              <X class="w-5 h-5" />
            </button>
          </div>

          <form @submit.prevent="submitForm" class="mt-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- Left Column: Session Selection -->
              <div class="space-y-6">
                <!-- Session Selection -->
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    <Calendar class="inline w-4 h-4 mr-1" />
                    Séance *
                  </label>
                  <select 
                    v-model="form.seance_id" 
                    required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                    @change="onSeanceChange"
                  >
                    <option value="" disabled>Sélectionner une séance</option>
                    <option v-for="seance in seances" :key="seance.id" :value="seance.id">
                    {{ formatDateRange(seance.date_debut) }}
                    </option>
                  </select>
                </div>

                <!-- Absence Options -->
                <div class="space-y-4">
                  <h4 class="font-medium text-gray-900">Options d'absence</h4>
                  <div class="space-y-3">
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                      <input 
                        v-model="form.justifie" 
                        type="checkbox" 
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                      />
                      <div class="ml-3">
                        <div class="flex items-center">
                          <CheckCircle class="w-4 h-4 mr-2 text-green-600" />
                          <span class="font-medium text-gray-900">Absence justifiée</span>
                        </div>
                        <p class="text-sm text-gray-500">Marquer ces absences comme justifiées</p>
                      </div>
                    </label>

                    <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                      <input 
                        v-model="form.est_sanctionnée" 
                        type="checkbox" 
                        class="w-4 h-4 text-orange-600 border-gray-300 rounded focus:ring-orange-500"
                      />
                      <div class="ml-3">
                        <div class="flex items-center">
                          <AlertTriangle class="w-4 h-4 mr-2 text-orange-600" />
                          <span class="font-medium text-gray-900">Absence sanctionnée</span>
                        </div>
                        <p class="text-sm text-gray-500">Appliquer une sanction pour ces absences</p>
                      </div>
                    </label>
                  </div>
                </div>

                <!-- Summary -->
                <div v-if="form.apprenant_ids.length > 0" class="p-4 bg-green-50 rounded-lg border border-green-200">
                  <div class="flex items-center mb-2">
                    <Users class="w-4 h-4 mr-2 text-green-600" />
                    <span class="font-medium text-green-900">Résumé</span>
                  </div>
                  <div class="text-sm text-green-800">
                    <p>{{ form.apprenant_ids.length }} apprenant{{ form.apprenant_ids.length > 1 ? 's' : '' }} sélectionné{{ form.apprenant_ids.length > 1 ? 's' : '' }}</p>
                    <p v-if="selectedSeance">Séance: {{ selectedSeance.matiere }}</p>
                    <p>Statut: {{ form.justifie ? 'Justifiée' : 'Non justifiée' }}{{ form.est_sanctionnée ? ', Sanctionnée' : '' }}</p>
                  </div>
                </div>
              </div>

              <!-- Right Column: Student Selection -->
              <div class="space-y-4">
                <!-- Search and filters -->
                <div class="space-y-3">
                  <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium text-gray-700">
                      <User class="inline w-4 h-4 mr-1" />
                      Apprenants *
                    </label>
                    <div class="text-sm text-gray-500">
                      {{ form.apprenant_ids.length }}/{{ filteredApprenants.length }} sélectionné{{ form.apprenant_ids.length > 1 ? 's' : '' }}
                    </div>
                  </div>

                  <!-- Search bar -->
                  <div class="relative">
                    <Search class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" />
                    <input
                      v-model="searchQuery"
                      type="text"
                      placeholder="Rechercher un apprenant..."
                      class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                  </div>

                  <!-- Quick actions -->
                  <div class="flex space-x-2">
                    <button
                      type="button"
                      @click="selectAll"
                      class="flex-1 px-3 py-2 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors"
                    >
                      <CheckSquare class="w-3 h-3 mr-1 inline" />
                      Tout sélectionner
                    </button>
                    <button
                      type="button"
                      @click="deselectAll"
                      class="flex-1 px-3 py-2 text-xs font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                    >
                      <Square class="w-3 h-3 mr-1 inline" />
                      Tout désélectionner
                    </button>
                  </div>
                </div>

                <!-- Students list -->
                <div class="border border-gray-200 rounded-lg max-h-80 overflow-y-auto">
                  <div v-if="filteredApprenants.length === 0" class="p-8 text-center text-gray-500">
                    <UserX class="w-8 h-8 mx-auto mb-2 text-gray-400" />
                    <p>Aucun apprenant trouvé</p>
                  </div>
                  
                  <div v-else class="divide-y divide-gray-200">
                    <label
                      v-for="apprenant in filteredApprenants"
                      :key="apprenant.id"
                      class="flex items-center p-3 hover:bg-gray-50 cursor-pointer transition-colors"
                      :class="{ 'bg-blue-50': form.apprenant_ids.includes(apprenant.id) }"
                    >
                      <input
                        type="checkbox"
                        :value="apprenant.id"
                        v-model="form.apprenant_ids"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                      />
                      <div class="ml-3 flex-1">
                        <div class="flex items-center">
                          <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3">
                            <span class="text-white text-xs font-medium">
                              {{ getInitials(apprenant.prenom, apprenant.nom) }}
                            </span>
                          </div>
                          <div>
                            <div class="text-sm font-medium text-gray-900">
                              {{ apprenant.prenom }} {{ apprenant.nom }}
                            </div>
                            <div class="text-xs text-gray-500">{{ apprenant.email }}</div>
                          </div>
                        </div>
                      </div>
                      <div v-if="form.apprenant_ids.includes(apprenant.id)" class="text-blue-600">
                        <CheckCircle class="w-4 h-4" />
                      </div>
                    </label>
                  </div>
                </div>

                <!-- Validation message -->
                <div v-if="showValidationError" class="p-3 bg-red-50 border border-red-200 rounded-lg">
                  <div class="flex items-center">
                    <AlertCircle class="w-4 h-4 mr-2 text-red-600" />
                    <span class="text-sm text-red-800">Veuillez sélectionner au moins un apprenant</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between pt-6 mt-6 border-t border-gray-200">
              <div class="text-sm text-gray-500">
                <span v-if="form.apprenant_ids.length > 0">
                  {{ form.apprenant_ids.length }} absence{{ form.apprenant_ids.length > 1 ? 's' : '' }} sera{{ form.apprenant_ids.length > 1 ? 'ont' : '' }} créée{{ form.apprenant_ids.length > 1 ? 's' : '' }}
                </span>
              </div>
              <div class="flex space-x-3">
                <button
                  type="button"
                  @click="close"
                  class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                >
                  Annuler
                </button>
                <button
                  type="submit"
                  :disabled="form.apprenant_ids.length === 0 || !form.seance_id"
                  class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
                >
                  <Save class="w-4 h-4 mr-2 inline" />
                  Créer {{ form.apprenant_ids.length }} absence{{ form.apprenant_ids.length > 1 ? 's' : '' }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import {
  X, Users, Calendar, Clock, BookOpen, User, Search, CheckSquare, Square,
  CheckCircle, AlertTriangle, AlertCircle, UserX, Save
} from 'lucide-vue-next'

// Props
const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  apprenants: {
    type: Array,
    default: () => [
      { id: 1, nom: 'Dupont', prenom: 'Jean', email: 'jean.dupont@email.com' },
      { id: 2, nom: 'Martin', prenom: 'Marie', email: 'marie.martin@email.com' },
      { id: 3, nom: 'Durand', prenom: 'Pierre', email: 'pierre.durand@email.com' },
      { id: 4, nom: 'Bernard', prenom: 'Sophie', email: 'sophie.bernard@email.com' },
      { id: 5, nom: 'Petit', prenom: 'Lucas', email: 'lucas.petit@email.com' }
    ]
  },
  seances: {
    type: Array,
    default: () => [
      {
        id: 1,
        date_debut: '2024-01-15T08:00:00Z',
        date_fin: '2024-01-15T10:00:00Z',
        matiere: 'Mathématiques'
      },
      {
        id: 2,
        date_debut: '2024-01-15T10:15:00Z',
        date_fin: '2024-01-15T12:15:00Z',
        matiere: 'Français'
      },
      {
        id: 3,
        date_debut: '2024-01-15T14:00:00Z',
        date_fin: '2024-01-15T16:00:00Z',
        matiere: 'Sciences'
      }
    ]
  }
})

// Emits
const emit = defineEmits(['close', 'submit'])

// Reactive data
const form = ref({
  seance_id: '',
  apprenant_ids: [],
  justifie: false,
  est_sanctionnée: false
})

const searchQuery = ref('')
const showValidationError = ref(false)

// Computed properties
const selectedSeance = computed(() => {
  return props.seances.find(s => s.id == form.value.seance_id)
})

const filteredApprenants = computed(() => {
  if (!searchQuery.value) return props.apprenants
  
  const query = searchQuery.value.toLowerCase()
  return props.apprenants.filter(apprenant =>
    `${apprenant.prenom} ${apprenant.nom}`.toLowerCase().includes(query) ||
    apprenant.email.toLowerCase().includes(query)
  )
})

// Watch for validation errors
watch(() => form.value.apprenant_ids, () => {
  if (showValidationError.value && form.value.apprenant_ids.length > 0) {
    showValidationError.value = false
  }
})

// Methods
const getInitials = (prenom, nom) => {
  return `${prenom?.[0] || ''}${nom?.[0] || ''}`.toUpperCase()
}

function formatDateRange(heure) {
  return new Date(`1970-01-01T${heure}Z`).toLocaleTimeString([], {
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  });
}

const selectAll = () => {
  form.value.apprenant_ids = filteredApprenants.value.map(a => a.id)
}

const deselectAll = () => {
  form.value.apprenant_ids = []
}

const onSeanceChange = () => {
  // Reset validation error when seance changes
  showValidationError.value = false
}

const submitForm = () => {
  if (form.value.apprenant_ids.length === 0) {
    showValidationError.value = true
    return
  }

  if (!form.value.seance_id) {
    alert('Veuillez sélectionner une séance.')
    return
  }

  // Emit the form data
  emit('submit', {
    ...form.value,
    // Additional metadata for better handling
    selectedSeance: selectedSeance.value,
    selectedApprenants: props.apprenants.filter(a => form.value.apprenant_ids.includes(a.id))
  })

  resetForm()
}

const resetForm = () => {
  form.value = {
    seance_id: '',
    apprenant_ids: [],
    justifie: false,
    est_sanctionnée: false
  }
  searchQuery.value = ''
  showValidationError.value = false
}

const close = () => {
  resetForm()
  emit('close')
}
</script>

<style scoped>
/* Modal transitions */
.modal-enter-active, .modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from, .modal-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

.overlay-enter-active, .overlay-leave-active {
  transition: opacity 0.3s ease;
}

.overlay-enter-from, .overlay-leave-to {
  opacity: 0;
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
  width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
  background: #a1a1a1;
}

/* Smooth transitions for all elements */
* {
  transition: all 0.2s ease-in-out;
}

/* Focus styles */
input:focus, select:focus, button:focus {
  outline: none;
}

/* Hover effects */
.hover\:bg-gray-50:hover {
  background-color: #f9fafb;
}

.hover\:bg-blue-50:hover {
  background-color: #eff6ff;
}
</style>