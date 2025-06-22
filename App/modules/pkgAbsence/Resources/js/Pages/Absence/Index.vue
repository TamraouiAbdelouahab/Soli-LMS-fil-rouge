<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 leading-tight">
          Gestion des Absences
        </h2>
        <div class="text-sm text-gray-500">
          {{ filteredAbsences.length }} absence(s) trouvée(s)
        </div>
      </div>
    </template>

    <div class="p-6 space-y-8">
      <!-- Boutons d'action -->
      <div class="flex justify-end gap-3">
        <button @click="openMultiModal"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-sm">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
          </svg>
          Ajouter Absences Groupées
        </button>
        <button @click="openModal"
                class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors duration-200 shadow-sm">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
          </svg>
          Nouvelle Absence
        </button>
      </div>

      <!-- Filtres -->
      <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filtres</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Filtre séance -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Séance</label>
            <select v-model="selectedSeance" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
              <option value="">Toutes les séances</option>
              <option v-for="s in seances" :key="s.id" :value="s.id">
                {{ formatDate(s.date_debut) }}
              </option>
            </select>
          </div>

          <!-- Filtre groupe -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Groupe</label>
            <select v-model="selectedGroupe" 
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
              <option value="">Tous les groupes</option>
              <option v-for="g in groupes" :key="g.id" :value="g.id">{{ g.nom }}</option>
            </select>
          </div>

          <!-- Recherche apprenant -->
          <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Rechercher un apprenant</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
              </div>
              <input
                v-model="searchApprenant"
                type="search"
                placeholder="Nom ou prénom..."
                class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Tableau -->
      <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Apprenant
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Séance
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Date d'absence
                </th>
                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Statut
                </th>
                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="absence in filteredAbsences" :key="absence.id" 
                  class="hover:bg-gray-50 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <span class="text-sm font-medium text-gray-700">
                          {{ (absence.apprenant?.nom?.charAt(0) || '') + (absence.apprenant?.prenom?.charAt(0) || '') }}
                        </span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ absence.apprenant?.nom }} {{ absence.apprenant?.prenom }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">
                    {{ formatDate(absence.seance?.date_debut) }} → {{ formatDate(absence.seance?.date_fin) }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 0h6m-6 0V7a1 1 0 00-1 1v9a2 2 0 002 2h4a2 2 0 002-2V8a1 1 0 00-1-1V7"/>
                    </svg>
                    <div class="text-sm font-medium text-gray-900">
                      {{ formatAbsenceDate(absence.created_at) }}
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="[
                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                    absence.justifie 
                      ? 'bg-green-100 text-green-800' 
                      : 'bg-red-100 text-red-800'
                  ]">
                    <svg :class="[
                      'w-1.5 h-1.5 mr-1.5',
                      absence.justifie ? 'text-green-400' : 'text-red-400'
                    ]" fill="currentColor" viewBox="0 0 8 8">
                      <circle cx="4" cy="4" r="3"/>
                    </svg>
                    {{ absence.justifie ? 'Justifiée' : 'Non justifiée' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                  <button @click="viewAbsence(absence)" 
                          class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                  </button>
                  <button @click="editAbsence(absence)" 
                          class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  <button @click="deleteAbsence(absence.id)" 
                          class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </td>
              </tr>
              <tr v-if="filteredAbsences.length === 0">
                <td colspan="5" class="px-6 py-12 text-center">
                  <div class="text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm">Aucune absence trouvée</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modales -->
    <AbsenceFormModal
      v-if="modalOpen"
      :absence="selectedAbsence"
      :apprenants="apprenants"
      :seances="seances"
      @close="closeModal"
      @submit="handleSubmitAbsence"
    />

    <AbsenceEditModal
      v-if="editModalOpen"
      :show="editModalOpen"
      :absence="selectedAbsence"
      :apprenants="apprenants"
      :seances="seances"
      @close="closeEditModal"
      @submit="handleSubmitAbsence"
    />

    <AbsenceMultiCreateModal
      v-if="multiModalOpen"
      :apprenants="apprenants"
      :seances="seances"
      :show="multiModalOpen"
      @close="multiModalOpen = false"
      @submit="handleSubmitMulti"
    />

    <AbsenceViewModal
      v-if="viewedAbsence"
      :show="!!viewedAbsence"
      :absence="viewedAbsence"
      @close="viewedAbsence = null"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js';

import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue'
import AbsenceFormModal from './AbsenceFormModal.vue'
import AbsenceEditModal from './AbsenceEditModal.vue'
import AbsenceMultiCreateModal from './AbsenceMultiCreateModal.vue'
import AbsenceViewModal from './AbsenceViewModal.vue'
import { ref, computed } from 'vue'

const props = defineProps({
  absences: Array,
  apprenants: Array,
  seances: Array,
  groupes: Array,
})

const selectedSeance = ref('')
const selectedGroupe = ref('')
const searchApprenant = ref('')

// Modales
const modalOpen = ref(false)
const editModalOpen = ref(false)
const multiModalOpen = ref(false)
const selectedAbsence = ref(null)
const viewedAbsence = ref(null)

// Fonctions modales
function openModal() {
  selectedAbsence.value = null
  modalOpen.value = true
}

function closeModal() {
  modalOpen.value = false
  selectedAbsence.value = null
}

function openMultiModal() {
  multiModalOpen.value = true
}

function viewAbsence(absence) {
  viewedAbsence.value = absence
}

function editAbsence(absence) {
  selectedAbsence.value = absence
  editModalOpen.value = true
}

function closeEditModal() {
  editModalOpen.value = false
  selectedAbsence.value = null
}

function deleteAbsence(id) {
  if (confirm('Êtes-vous sûr de vouloir supprimer cette absence ?')) {
    router.delete(route('Absences.destroy', id))
  }
}

function handleSubmitAbsence(data) {
  if (selectedAbsence.value) {
    router.put(route('Absences.update', selectedAbsence.value.id), data)
  } else {
    router.post(route('Absences.store'), data)
  }
  closeModal()
  closeEditModal()
}

function handleSubmitMulti(data) {
  router.post(route('Absences.store'), data)
  multiModalOpen.value = false
}

// filter des absences
const filteredAbsences = computed(() => {
  return props.absences.filter(absence => {
    // filtre séance
    const matchesSeance = selectedSeance.value
      ? absence.seance?.id === Number(selectedSeance.value)
      : true;

    // filtre groupe (via apprenant.groupe_id)
    const matchesGroupe = selectedGroupe.value
      ? absence.apprenant?.groupe_id === selectedGroupe.value
      : true

    // filtre recherche sur nom/prenom (insensible à la casse)
    const fullName = (absence.apprenant?.nom + ' ' + absence.apprenant?.prenom).toLowerCase()
    const search = searchApprenant.value.trim().toLowerCase()
    const matchesSearch = search ? fullName.includes(search) : true

    return matchesSeance && matchesGroupe && matchesSearch
  })
})

// Formattage des dates
function formatDate(heure) {
  return new Date(`1970-01-01T${heure}Z`).toLocaleTimeString([], {
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  });
}

// Formattage de la date d'absence (seulement la date)
function formatAbsenceDate(dateString) {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleDateString('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  })
}
</script>
