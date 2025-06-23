<template>
  <ul class="divide-y divide-gray-200">
    <li v-for="apprenant in frequentAbsentees" :key="apprenant.apprenant_id" class="py-2 flex justify-between items-center">
      <span class="text-gray-800 font-medium">{{ apprenant.nom }} {{ apprenant.prenom }}</span>
      <span class="text-red-600 font-semibold">{{ apprenant.total }} absences</span>
    </li>
    <li v-if="frequentAbsentees.length === 0" class="py-4 text-center text-gray-500">
      Aucun apprenant absent fréquemment ce mois-ci.
    </li>
  </ul>
</template>

<script setup>
const props = defineProps({
  frequentAbsentees: {
    type: Array,
    default: () => [],
  },
});
</script>
