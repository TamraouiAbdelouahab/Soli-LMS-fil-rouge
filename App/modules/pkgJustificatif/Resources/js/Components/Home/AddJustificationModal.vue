<template>
  <div
  v-if="show"

  >

    <div
      class="fixed inset-0 py-8 flex items-center justify-center bg-black bg-opacity-50 z-50 "
    >
      <div class="bg-white  m-4 p-6 rounded-lg shadow-xl w-3/4 overflow-y-auto max-h-[calc(100vh-2vh)] dark:bg-gray-800 ">
        <h2 class="text-xl font-semibold mb-4 dark:text-white">Ajouter un justification</h2>
        <div class="flex justify-between gap-4 w-full">
            <div class="w-1/2">
                <label  for="dateDebut" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Date debut
                </label>
                <input  type="date" id="date dateDebut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                        placeholder="01/01/2025" required />
            </div>
            <div class="w-1/2">
                <label  for="dateFin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Date fin
                </label>
                <input  type="date" id="dateFin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                        placeholder="02/01/2025" required />
            </div>
        </div>
        <div class="flex justify-between gap-4 w-full">
          <div class="w-1/2">
              <label  for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white w-full">
                status
              </label>
              <select name="" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
                <option v-for="[key, status] in Object.entries(statuses)" :value="key" :key="key">{{status}}</option>
              </select>
          </div>
          <div class="w-1/2">
              <label for="raison" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                raison
              </label>
              <div class="flex justify-between gap-4 w-full items-start">
                <select name="" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
                  <option v-for="reason in props.reasons" :value="reason.id" :key="reason.id">{{reason.libelle}}</option>
                </select>
                <!-- <button
                      class="bg-blue-500 text-white px-4 py-2 rounded">
                      +
                </button> -->
              </div>
          </div>
        </div>
        <div class="flex justify-between gap-4 w-full">
          <div class="w-1/2">
              <label  for="groupe" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Groupe
              </label>
              <select name="groupe" id="groupe" v-model="groupe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
                <option v-for="group in props.groups" :value="group.id" :key="group.id">{{group.nom}}</option>
              </select>
          </div>
          <div class="w-1/2">
              <label  for="apprenant" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                apprenant
              </label>
              <select name="groupe" id="groupe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
                <option v-for="apprenant in apprenantsDuGroupe" :value="apprenant.id" :key="apprenant.id">{{apprenant.nom + " " + apprenant.prenom}}</option>
              </select>
          </div>
        </div>
        <div>
            <label  for="fichier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Fichier
            </label>
            <input  type="file" id="fichier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                    placeholder=".png,.jpg.pdf" required />
        </div>
        <div>
            <label  for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Description
            </label>
            <textarea name="description" id="description" placeholder="Optional"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
            ></textarea>
            <!-- <input type="text" id="description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                    placeholder="description" required /> -->
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
  </div>
</template>

<script setup>
import { computed } from 'vue';
import { ref } from 'vue';

const props = defineProps(['show','reasons','groups'])

console.log(props.groups);


const groupe = ref(props.groups[0].id);

const apprenantsDuGroupe =ref( computed(() => {
  const selectedGroup = props.groups.find(g => g.id === groupe.value);
  return selectedGroup ? selectedGroup.apprenants : [];
}));
console.log("--------------------")
console.log(apprenantsDuGroupe.value)
console.log(props.reasons)
const statuses = ref({
  "EN_ATTENTE": "an attente",
  "ACCEPTE": "accepte",
  "REJETE": "rejete",
})
</script>
