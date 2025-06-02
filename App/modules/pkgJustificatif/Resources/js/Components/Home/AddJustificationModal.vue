<template>
  <div
    v-if="show"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white p-6 rounded-lg shadow-xl  w-3/4">
      <h2 class="text-xl font-semibold mb-4">Ajouter un justification</h2>
      <div>
          <label  for="dateDebut" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Date debut
          </label>
          <input  type="text" id="date dateDebut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" 
                  placeholder="01/01/2025" required />
      </div>
      <div>
          <label  for="dateFin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Date fin
          </label>
          <input  type="text" id="dateFin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" 
                  placeholder="02/01/2025" required />
      </div>
      <div>
          <label  for="fichier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Fichier
          </label>
          <input  type="text" id="fichier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" 
                  placeholder=".png,.jpg.pdf" required />
      </div>
      <div>
          <label  for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Description
          </label>
          <input  type="text" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2" 
                  placeholder="description" required />
      </div>
      <div>
          <label  for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white w-full">
            status
          </label>
          <select name="" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
            <option v-for="[key, status] in Object.entries(statuses)" :value="key" :key="key">{{status}}</option>
          </select>          
      </div>
      <div>
          <label for="raison" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            raison
          </label>
          <select name="" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
            <option v-for="reason in props.reasons" :value="reason.id" :key="reason.id">{{reason.libelle}}</option>
          </select> 
      </div>
      <div>
          <label  for="groupe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            Groupe
          </label>
          <select name="groupe" id="groupe" v-model="groupe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
            <option v-for="group in props.groups" :value="group.id" :key="group.id">{{group.nom}}</option>
          </select> 
      </div>
      <div>
          <label  for="apprenant" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
            apprenant
          </label>
          <select name="groupe" id="groupe" v-model="groupe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
            <option v-for="apprenant in apprenantsDuGroupe" :value="apprenant.id" :key="apprenant.id">{{apprenant.nom}}</option>
          </select>
      </div>
      <div class="flex items-center justify-between">
          <button
            @click="$emit('close')"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            Fermer
          </button>
          <button
            @click="$emit('close')"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          >
            Ajouter
          </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { ref } from 'vue';

const props = defineProps(['show','reasons','groups'])

console.log(props.groups);


const groupe = ref(props.groups[1].id);

const apprenantsDuGroupe = computed(() => {
  const selectedGroup = props.groups.find(g => g.id === groupe.value);
  return selectedGroup ? selectedGroup.apprenants : [];
});
console.log(props.reasons)
const statuses = ref({
  "EN_ATTENTE": "an attente",
  "ACCEPTE": "accepte",
  "REJETE": "rejete",
})
</script>
