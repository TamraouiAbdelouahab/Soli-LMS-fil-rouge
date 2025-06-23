<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Gestion des Absences</h1>
          <p class="mt-1 text-sm text-gray-600">
            Gérez et suivez les absences des apprenants
          </p>
        </div>
        <div class="flex items-center gap-3">
          <div class="bg-white px-3 py-2 rounded-lg border border-gray-200 shadow-sm">
            <span class="text-sm font-medium text-gray-700">
              {{ filteredAbsences.length }} absence{{ filteredAbsences.length > 1 ? 's' : '' }}
            </span>
          </div>
        </div>
      </div>
    </template>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Messages d'erreur avec animation -->
      <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
      >
        <div v-if="hasErrors" class="mb-6">
          <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Erreurs de validation</h3>
                <div class="mt-2 text-sm text-red-700">
                  <ul class="list-disc list-inside space-y-1">
                    <li v-for="(error, field) in $page.props.errors" :key="field">
                      <span class="font-medium">{{ field }}:</span> 
                      {{ Array.isArray(error) ? error.join(', ') : error }}
                    </li>
                  </ul>
                </div>
              </div>
              <div class="ml-auto pl-3">
                <button @click="clearErrors" class="text-red-400 hover:text-red-600">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </Transition>

      <!-- Actions et filtres dans une carte unifiée -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <!-- En-tête avec actions -->
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-lg font-semibold text-gray-900">Filtres et Actions</h2>
            <div class="flex flex-col sm:flex-row gap-3">
              <button
                @click="openMultiModal"
                class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Absences Groupées
              </button>
              <button
                @click="openModal"
                class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium rounded-lg transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5"
              >
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Nouvelle Absence
              </button>
            </div>
          </div>
        </div>

        <!-- Filtres améliorés -->
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Filtre séance -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Séance
              </label>
              <select 
                v-model="selectedSeance" 
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors duration-200"
              >
                <option value="">Toutes les séances</option>
                <option v-for="s in seances" :key="s.id" :value="s.id">
                  {{ formatSessionDisplay(s) }}
                </option>
              </select>
            </div>

            <!-- Filtre groupe -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Groupe
              </label>
              <select 
                v-model="selectedGroupe" 
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors duration-200"
              >
                <option value="">Tous les groupes</option>
                <option v-for="g in groupes" :key="g.id" :value="g.id">{{ g.nom }}</option>
              </select>
            </div>

            <!-- Recherche apprenant -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Rechercher un apprenant
              </label>
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
                  class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors duration-200"
                />
                <div v-if="searchApprenant" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                  <button @click="searchApprenant = ''" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                  </button>
                </div>
              </div>
            </div>

            <!-- Filtre statut -->
            <div class="space-y-2">
              <label class="block text-sm font-medium text-gray-700">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Statut
              </label>
              <select 
                v-model="selectedStatus" 
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition-colors duration-200"
              >
                <option value="">Tous les statuts</option>
                <option value="justified">Justifiées</option>
                <option value="unjustified">Non justifiées</option>
                <option value="sanctioned">Sanctionnées</option>
              </select>
            </div>
          </div>

          <!-- Bouton de réinitialisation des filtres -->
          <div v-if="hasActiveFilters" class="mt-4 flex justify-end">
            <button
              @click="clearFilters"
              class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
              </svg>
              Réinitialiser les filtres
            </button>
          </div>
        </div>
      </div>

      <!-- Tableau amélioré -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Liste des Absences</h3>
            <div class="flex items-center space-x-2 text-sm text-gray-500">
              <span>{{ filteredAbsences.length }} résultat{{ filteredAbsences.length > 1 ? 's' : '' }}</span>
            </div>
          </div>
        </div>

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
              <tr 
                v-for="absence in paginatedAbsences" 
                :key="absence.id" 
                class="hover:bg-gray-50 transition-colors duration-150"
              >
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0">
                      <div class="h-12 w-12 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-sm">
                        <span class="text-sm font-bold text-white">
                          {{ getInitials(absence.apprenant) }}
                        </span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ absence.apprenant?.nom }} {{ absence.apprenant?.prenom }}
                      </div>
                      <div v-if="absence.apprenant?.groupes?.length" class="text-xs text-gray-500">
                        <span class="inline-flex items-center">
                          <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                          </svg>
                          {{ absence.apprenant.groupes.map(g => g.nom).join(', ') }}
                        </span>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900 font-medium">
                    {{ formatSessionDisplay(absence.seance) }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center text-sm text-gray-900">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 0h6m-6 0V7a1 1 0 00-1 1v9a2 2 0 002 2h4a2 2 0 002-2V8a1 1 0 00-1-1V7"/>
                    </svg>
                    {{ formatAbsenceDate(absence.created_at) }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex flex-col space-y-1">
                    <span :class="getStatusBadgeClass(absence)">
                      <svg :class="getStatusIconClass(absence)" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      {{ getStatusText(absence) }}
                    </span>
                    <span v-if="absence.est_sanctionnée" class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                      <svg class="w-1.5 h-1.5 mr-1 text-orange-400" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      Sanctionnée
                    </span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right">
                  <div class="flex items-center justify-end space-x-2">
                    <button 
                      @click="viewAbsence(absence)" 
                      class="inline-flex items-center p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200"
                      title="Voir les détails"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                    </button>
                    <button 
                      @click="editAbsence(absence)" 
                      class="inline-flex items-center p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all duration-200"
                      title="Modifier"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </button>
                    <button 
                      @click="confirmDelete(absence)" 
                      class="inline-flex items-center p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200"
                      title="Supprimer"
                    >
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>

          <!-- État vide amélioré -->
          <div v-if="filteredAbsences.length === 0" class="text-center py-16">
            <div class="mx-auto h-24 w-24 text-gray-300 mb-4">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune absence trouvée</h3>
            <p class="text-gray-500 mb-6">
              {{ hasActiveFilters ? 'Essayez de modifier vos critères de recherche.' : 'Commencez par ajouter une nouvelle absence.' }}
            </p>
            <button
              v-if="!hasActiveFilters"
              @click="openModal"
              class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors duration-200"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              Ajouter une absence
            </button>
          </div>
        </div>

        <!-- Pagination -->
        <div v-if="filteredAbsences.length > itemsPerPage" class="px-6 py-4 border-t border-gray-200">
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-700">
              Affichage de {{ ((currentPage - 1) * itemsPerPage) + 1 }} à 
              {{ Math.min(currentPage * itemsPerPage, filteredAbsences.length) }} 
              sur {{ filteredAbsences.length }} résultats
            </div>
            <div class="flex items-center space-x-2">
              <button
                @click="currentPage--"
                :disabled="currentPage === 1"
                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Précédent
              </button>
              <span class="px-3 py-2 text-sm font-medium text-gray-700">
                Page {{ currentPage }} sur {{ totalPages }}
              </span>
              <button
                @click="currentPage++"
                :disabled="currentPage === totalPages"
                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                Suivant
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modales -->
    <AbsenceFormModal
      :show="modalOpen"
      :absence="selectedAbsence"
      :apprenants="apprenants"
      :seances="seances"
      :sanctions="sanctions"
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

    <!-- Modal de confirmation de suppression -->
    <ConfirmationModal
      :show="showDeleteConfirm"
      :title="'Supprimer l\'absence'"
      :message="`Êtes-vous sûr de vouloir supprimer l'absence de ${absenceToDelete?.apprenant?.nom} ${absenceToDelete?.apprenant?.prenom} ?`"
      :confirmText="'Supprimer'"
      :cancelText="'Annuler'"
      :type="'danger'"
      @confirm="deleteAbsence"
      @cancel="cancelDelete"
    />
  </AuthenticatedLayout>
</template>

<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { ref, computed, watch } from 'vue'

import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue'
import AbsenceFormModal from './AbsenceFormModal.vue'
import AbsenceEditModal from './AbsenceEditModal.vue'
import AbsenceMultiCreateModal from './AbsenceMultiCreateModal.vue'
import AbsenceViewModal from './AbsenceViewModal.vue'
import ConfirmationModal from './ConfirmationModal.vue'

const $page = usePage()

const props = defineProps({
  absences: Array,
  apprenants: Array,
  seances: Array,
  groupes: Array,
  sanctions: Array,
})

// État des filtres
const selectedSeance = ref('')
const selectedGroupe = ref('')
const searchApprenant = ref('')
const selectedStatus = ref('')

// État des modales
const modalOpen = ref(false)
const editModalOpen = ref(false)
const multiModalOpen = ref(false)
const selectedAbsence = ref(null)
const viewedAbsence = ref(null)

// État de la suppression
const showDeleteConfirm = ref(false)
const absenceToDelete = ref(null)

// Pagination
const currentPage = ref(1)
const itemsPerPage = ref(10)

// Computed properties
const hasErrors = computed(() => {
  return $page.props.errors && Object.keys($page.props.errors).length > 0
})

const hasActiveFilters = computed(() => {
  return selectedSeance.value || selectedGroupe.value || searchApprenant.value || selectedStatus.value
})

const filteredAbsences = computed(() => {
  return props.absences.filter(absence => {
    // Filtre séance
    const matchesSeance = !selectedSeance.value || absence.seance?.id === Number(selectedSeance.value)
    
    // Filtre groupe
    const matchesGroupe = !selectedGroupe.value || 
      absence.apprenant?.groupes?.some(groupe => groupe.id === Number(selectedGroupe.value))
    
    // Filtre recherche
    const fullName = `${absence.apprenant?.nom || ''} ${absence.apprenant?.prenom || ''}`.toLowerCase()
    const search = searchApprenant.value.trim().toLowerCase()
    const matchesSearch = !search || fullName.includes(search)
    
    // Filtre statut
    let matchesStatus = true
    if (selectedStatus.value === 'justified') {
      matchesStatus = absence.justifie
    } else if (selectedStatus.value === 'unjustified') {
      matchesStatus = !absence.justifie
    } else if (selectedStatus.value === 'sanctioned') {
      matchesStatus = absence.est_sanctionnée
    }
    
    return matchesSeance && matchesGroupe && matchesSearch && matchesStatus
  })
})

const totalPages = computed(() => {
  return Math.ceil(filteredAbsences.value.length / itemsPerPage.value)
})

const paginatedAbsences = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredAbsences.value.slice(start, end)
})

// Watchers
watch(filteredAbsences, () => {
  currentPage.value = 1
})

// Méthodes
function clearErrors() {
  // Cette fonction pourrait être utilisée pour nettoyer les erreurs côté client
}

function clearFilters() {
  selectedSeance.value = ''
  selectedGroupe.value = ''
  searchApprenant.value = ''
  selectedStatus.value = ''
}

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

function confirmDelete(absence) {
  absenceToDelete.value = absence
  showDeleteConfirm.value = true
}

function deleteAbsence() {
  if (absenceToDelete.value) {
    router.delete(route('Absences.destroy', absenceToDelete.value.id), {
      onSuccess: () => {
        showDeleteConfirm.value = false
        absenceToDelete.value = null
      }
    })
  }
}

function cancelDelete() {
  showDeleteConfirm.value = false
  absenceToDelete.value = null
}

function handleSubmitAbsence(data) {
  const submitData = {
    ...data,
    user_id: $page.props.auth?.user?.id || null
  }
  
  if (selectedAbsence.value) {
    router.put(route('Absences.update', selectedAbsence.value.id), submitData, {
      onSuccess: () => {
        closeModal()
        closeEditModal()
      }
    })
  } else {
    router.post(route('Absences.store'), submitData, {
      onSuccess: () => {
        closeModal()
        closeEditModal()
      }
    })
  }
}

function handleSubmitMulti(data) {
  router.post(route('Absences.store'), data, {
    onSuccess: () => {
      multiModalOpen.value = false
    }
  })
}

// Fonctions utilitaires
function getInitials(apprenant) {
  if (!apprenant) return '??'
  const nom = apprenant.nom?.charAt(0) || ''
  const prenom = apprenant.prenom?.charAt(0) || ''
  return (nom + prenom).toUpperCase()
}

function formatSessionDisplay(seance) {
  if (!seance) return 'N/A'
  return `${formatTime(seance.date_debut)} → ${formatTime(seance.date_fin)}`
}

function formatTime(heure) {
  if (!heure) return 'N/A'
  try {
    return new Date(`1970-01-01T${heure}Z`).toLocaleTimeString([], {
      hour: '2-digit',
      minute: '2-digit',
      hour12: false
    })
  } catch {
    return heure
  }
}

function formatAbsenceDate(dateString) {
  if (!dateString) return 'N/A'
  try {
    return new Date(dateString).toLocaleDateString('fr-FR', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    })
  } catch {
    return 'Date invalide'
  }
}

function getStatusBadgeClass(absence) {
  const baseClass = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium'
  return absence.justifie 
    ? `${baseClass} bg-green-100 text-green-800`
    : `${baseClass} bg-red-100 text-red-800`
}

function getStatusIconClass(absence) {
  const baseClass = 'w-1.5 h-1.5 mr-1.5'
  return absence.justifie 
    ? `${baseClass} text-green-400`
    : `${baseClass} text-red-400`
}

function getStatusText(absence) {
  return absence.justifie ? 'Justifiée' : 'Non justifiée'
}
</script>
