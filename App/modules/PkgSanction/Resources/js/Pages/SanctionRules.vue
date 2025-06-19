<template>
  <AuthenticatedLayout>
    <div class="min-h-screen bg-gray-50 p-4 md:p-6">

      <!-- Page Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">Règles de Sanction</h1>
          <p class="text-lg text-gray-600">Gérez les règles et paramètres de sanction de votre établissement</p>
        </div>

        <div class="mt-4 sm:mt-0 flex space-x-3">
          <button @click="exportRules"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-light-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            <Download class="h-4 w-4 mr-2" />
            Exporter
          </button>

          <button @click="showAddRuleModal = true"
            class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
            <Plus class="h-4 w-4 mr-2" />
            Nouvelle Règle
          </button>
        </div>
      </div>

      <!-- Stats Cards -->
      <!-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <StatCard title="Total des Règles" :value="rulesCount" color="blue" icon="FileText" textSize="text-2xl" />
        <StatCard title="Règles Actives" :value="activeRulesCount" color="green" icon="CheckCircle"
          textSize="text-2xl" />
        <StatCard title="Dernière Modification" :value="formatDate(lastModificationDate)" color="orange" icon="Clock"
          textSize="text-sm" />
        <StatCard title="Apprenants Concernés" :value="learnersSanctionedCount" color="purple" icon="Users"
          textSize="text-2xl" />
      </div> -->

      <!-- Rules Table -->
      <RulesTable :rules="sanctionRules" @view="viewRule" @edit="editRule" @toggle-status="toggleRuleStatus"
        @delete="deleteRule" :formatDate="formatDate" />

      <!-- Add Rule Modal -->
      <AddRuleModal v-if="showAddRuleModal" :sanctionTypes="sanctionTypes" @close="showAddRuleModal = false"
        @submit="handleAddRule" />

      <!-- View Rule Modal -->
      <ViewRuleModal v-if="showViewModal && selectedRule" :rule="selectedRule" @close="showViewModal = false"
        :formatDate="formatDate" />

      <!-- Edit Rule Modal -->
      <EditRuleModal v-if="showEditModal && selectedRule" :sanctionTypes="sanctionTypes" :rule="selectedRule"
        @close="showEditModal = false" @submit="handleEditRule" />
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import {
  Home,
  ChevronRight,
  Search,
  Download,
  Plus,
  FileText,
  CheckCircle,
  Clock,
  Users,
  Bell,
  Calendar,
  Eye,
  Edit,
  Power,
  Trash2
} from 'lucide-vue-next';

import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import AddRuleModal from '../Components/Sanction/AddRuleModal.vue';
import ViewRuleModal from '../Components/Sanction/ViewRuleModal.vue';
import EditRuleModal from '../Components/Sanction/EditRuleModal.vue';
import StatCard from '../Components/Sanction/StatCard.vue';
import RulesTable from '../Components/Sanction/RulesTable.vue';

const props = defineProps({
  sanctionRules: Array,
  rulesCount: Number,
  activeRulesCount: Number,
  lastModificationDate: String,
  learnersSanctionedCount: Number,
  sanctionTypes: Array,
});
console.log('Props:', props.sanctionTypes);
// Reactive data
const searchQuery = ref('');
const statusFilter = ref('');
const showAddRuleModal = ref(false);
const showViewModal = ref(false);
const showEditModal = ref(false);
const selectedRule = ref(null);
const rules = ref([]);

// Methods
const formatDate = (date) => {
  const parsedDate = new Date(date);
  if (isNaN(parsedDate)) return 'Date invalide';
  return new Intl.DateTimeFormat('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  }).format(parsedDate);
};

const formStatRule = useForm({
  est_actif: 0,
});

const toggleRuleStatus = (rule) => {
  formStatRule.est_actif = rule.est_actif === 1 ? 0 : 1;
  formStatRule.put(`/sanction/rules/${rule.id}/toggle-status`, {
    preserveScroll: true,
    onSuccess: () => {
      rule.est_actif = formStatRule.est_actif;
    },
  });
};


const deleteRule = (rule) => {
  if (confirm(`Êtes-vous sûr de vouloir supprimer la règle "${rule.titre}"? Cette action est irréversible.`)) {
    router.delete(route('sanction.rules.destroy', rule.id), {
      preserveScroll: true,
    });
  }
};

const viewRule = (rule) => {
  selectedRule.value = rule;
  showViewModal.value = true;
};

const editRule = (rule) => {
  selectedRule.value = rule;
  showEditModal.value = true;
};

function exportRules() {
  window.location.href = route('sanction.rules.export');
}
</script>

<style scoped>
/* Custom scrollbar for table */
.overflow-x-auto::-webkit-scrollbar {
  height: 6px;
}

.overflow-x-auto::-webkit-scrollbar-track {
  background: #f1f1f1;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
  background: #a8a8a8;
}

/* Smooth transitions */
tr {
  transition: background-color 0.2s ease;
}

button {
  transition: all 0.2s ease;
}

/* Focus states */
button:focus {
  outline: 2px solid #3b82f6;
  outline-offset: 2px;
}
</style>