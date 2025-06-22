<template>
  <div>
    <h1>Ajouter des absences</h1>

    <!-- Sélection du groupe pour filtrer -->
    <label for="groupe">Filtrer par groupe :</label>
    <select v-model="selectedGroupe" @change="filterApprenants" id="groupe" class="border p-2 mb-4">
      <option value="">-- Choisir un groupe --</option>
      <option v-for="g in groupes" :key="g.id" :value="g.id">{{ g.nom }}</option>
    </select>

    <!-- Liste des apprenants filtrés -->
    <div v-if="filteredApprenants.length">
      <p>Sélectionnez les apprenants :</p>
      <div v-for="apprenant in filteredApprenants" :key="apprenant.id" class="flex items-center mb-1">
        <input type="checkbox" :id="'apprenant-' + apprenant.id" :value="apprenant.id" v-model="selectedApprenants" />
        <label :for="'apprenant-' + apprenant.id" class="ml-2">{{ apprenant.nom }} {{ apprenant.prenom }}</label>
      </div>
    </div>

    <!-- Choix séance -->
    <label for="seance">Séance :</label>
    <select v-model="seance_id" id="seance" class="border p-2 mb-4" required>
      <option value="">-- Choisir une séance --</option>
      <option v-for="s in seances" :key="s.id" :value="s.id">
        {{ new Date(s.date_debut).toLocaleDateString() }}
      </option>
    </select>

    <!-- Justifié -->
    <label class="inline-flex items-center mb-4">
      <input type="checkbox" v-model="justifie" class="form-checkbox" />
      <span class="ml-2">Justifié</span>
    </label>

    <!-- Est sanctionnée -->
    <label class="inline-flex items-center mb-4">
      <input type="checkbox" v-model="est_sanctionnee" class="form-checkbox" />
      <span class="ml-2">Est sanctionnée</span>
    </label>

    <!-- Bouton valider -->
    <button
      @click="submit"
      :disabled="!seance_id || selectedApprenants.length === 0"
      class="bg-blue-600 text-white px-4 py-2 rounded disabled:opacity-50"
    >
      Ajouter les absences
    </button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  groupes: Array,
  apprenants: Array,
  seances: Array,
});

const selectedGroupe = ref('');
const filteredApprenants = ref([]);
const selectedApprenants = ref([]);
const seance_id = ref('');
const justifie = ref(false);
const est_sanctionnee = ref(false);

function filterApprenants() {
  if (!selectedGroupe.value) {
    filteredApprenants.value = [];
    selectedApprenants.value = [];
    return;
  }
  filteredApprenants.value = props.apprenants.filter(apprenant =>
    apprenant.groupes.some(g => g.id === parseInt(selectedGroupe.value))
  );
  selectedApprenants.value = [];
}

function submit() {
  Inertia.post(route('Absences.bulkStore'), {
    seance_id: seance_id.value,
    apprenant_ids: selectedApprenants.value,
    justifie: justifie.value,
    est_sanctionnée: est_sanctionnee.value,
  });
}
</script>
