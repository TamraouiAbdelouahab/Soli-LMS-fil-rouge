<template>
    <AuthenticatedLayout>
    <div class="min-h-screen bg-gray-50">
      <!-- Header Section -->
      <!-- <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex items-center justify-between h-16">
            <nav class="flex items-center space-x-2 text-sm">
              <a href="#" class="text-gray-500 hover:text-gray-700 flex items-center">
                <Home class="h-4 w-4 mr-1" />
                Dashboard
              </a>
              <ChevronRight class="h-4 w-4 text-gray-400" />
              <span class="text-gray-900 font-medium">Règles de Sanction</span>
            </nav>
  
            <div class="flex items-center space-x-3">
              <div class="relative">
                <Search class="h-4 w-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Rechercher une règle..."
                  class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
              </div>
            </div>
          </div>
        </div>
      </div> -->
  
      <!-- Main Content -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
          <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Règles de Sanction</h1>
            <p class="text-lg text-gray-600">Gérez les règles et paramètres de sanction de votre établissement</p>
          </div>
          
          <div class="mt-4 sm:mt-0 flex space-x-3">
            <button
              @click="exportRules"
              class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <Download class="h-4 w-4 mr-2" />
              Exporter
            </button>
            
            <button
              @click="showAddRuleModal = true"
              class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
              <Plus class="h-4 w-4 mr-2" />
              Nouvelle Règle
            </button>
          </div>
        </div>
  
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <FileText class="h-8 w-8 text-blue-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Total des Règles</p>
                <p class="text-2xl font-bold text-gray-900">{{ rules.length }}</p>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <CheckCircle class="h-8 w-8 text-green-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Règles Actives</p>
                <p class="text-2xl font-bold text-gray-900">{{ activeRulesCount }}</p>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <Clock class="h-8 w-8 text-orange-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Dernière Modification</p>
                <p class="text-sm font-bold text-gray-900">{{ lastModified }}</p>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <Users class="h-8 w-8 text-purple-600" />
              </div>
              <div class="ml-4">
                <p class="text-sm font-medium text-gray-500">Apprenants Concernés</p>
                <p class="text-2xl font-bold text-gray-900">{{ totalStudents }}</p>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Rules Table -->
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
          <!-- Table Header -->
          <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
              <h2 class="text-lg font-semibold text-gray-800">Liste des Règles</h2>
              <div class="flex items-center space-x-2">
                <select 
                  v-model="statusFilter"
                  class="text-sm border border-gray-300 rounded-md px-3 py-1 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                  <option value="">Tous les statuts</option>
                  <option value="active">Actif</option>
                  <option value="inactive">Inactif</option>
                </select>
              </div>
            </div>
          </div>
  
          <!-- Table Content -->
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Règle
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Paramètres
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Statut
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Dernière Modification
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="rule in filteredRules" :key="rule.id" class="hover:bg-gray-50">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ rule.titre }}</div>
                      <div class="text-sm text-gray-500 max-w-xs truncate">{{ rule.description }}</div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">
                      <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                          <Users class="h-3 w-3 mr-1" />
                          Max: {{ rule.absencesMax }}
                        </span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                          <Bell class="h-3 w-3 mr-1" />
                          Seuil: {{ rule.seuilDeNotification }}
                        </span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          <Calendar class="h-3 w-3 mr-1" />
                          {{ rule.dureeSanction }}j
                        </span>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span :class="[
                      'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                      rule.statut === 'active' 
                        ? 'bg-green-100 text-green-800' 
                        : 'bg-red-100 text-red-800'
                    ]">
                      {{ rule.statut === 'active' ? 'Actif' : 'Inactif' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ formatDate(rule.dateModification) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-2">
                      <button
                        @click="viewRule(rule)"
                        class="text-blue-600 hover:text-blue-900"
                        title="Voir les détails"
                      >
                        <Eye class="h-4 w-4" />
                      </button>
                      <button
                        @click="editRule(rule)"
                        class="text-indigo-600 hover:text-indigo-900"
                        title="Modifier"
                      >
                        <Edit class="h-4 w-4" />
                      </button>
                      <button
                        @click="toggleRuleStatus(rule)"
                        :class="[
                          'hover:opacity-75',
                          rule.statut === 'active' ? 'text-red-600' : 'text-green-600'
                        ]"
                        :title="rule.statut === 'active' ? 'Désactiver' : 'Activer'"
                      >
                        <Power class="h-4 w-4" />
                      </button>
                      <button
                        @click="deleteRule(rule)"
                        class="text-red-600 hover:text-red-900"
                        title="Supprimer"
                      >
                        <Trash2 class="h-4 w-4" />
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
  
          <!-- Empty State -->
          <div v-if="filteredRules.length === 0" class="text-center py-12">
            <FileText class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune règle trouvée</h3>
            <p class="mt-1 text-sm text-gray-500">
              {{ searchQuery ? 'Aucune règle ne correspond à votre recherche.' : 'Commencez par créer une nouvelle règle de sanction.' }}
            </p>
            <div class="mt-6">
              <button
                @click="showAddRuleModal = true"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700"
              >
                <Plus class="h-4 w-4 mr-2" />
                Nouvelle Règle
              </button>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Add Rule Modal -->
      <AddRuleModal 
        v-if="showAddRuleModal"
        @close="showAddRuleModal = false"
        @submit="handleAddRule"
      />
  
      <!-- View Rule Modal -->
      <ViewRuleModal 
        v-if="showViewModal && selectedRule"
        :rule="selectedRule"
        @close="showViewModal = false"
      />
  
      <!-- Edit Rule Modal -->
      <EditRuleModal 
        v-if="showEditModal && selectedRule"
        :rule="selectedRule"
        @close="showEditModal = false"
        @submit="handleEditRule"
      />
    </div>
</AuthenticatedLayout>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue';
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
  
  // Reactive data
  const searchQuery = ref('');
  const statusFilter = ref('');
  const showAddRuleModal = ref(false);
  const showViewModal = ref(false);
  const showEditModal = ref(false);
  const selectedRule = ref(null);
  
  // Sample rules data
  const rules = ref([
    {
      id: 1,
      titre: 'Règle d\'absentéisme niveau 1',
      description: 'Règle de base pour les absences non justifiées. Application automatique après dépassement du seuil.',
      absencesMax: 5,
      seuilDeNotification: 3,
      dureeSanction: 7,
      statut: 'active',
      dateModification: new Date('2024-01-15'),
      dateCreation: new Date('2024-01-10')
    },
    {
      id: 2,
      titre: 'Règle d\'absentéisme niveau 2',
      description: 'Règle renforcée pour les cas récidivistes. Sanctions plus sévères avec suivi personnalisé.',
      absencesMax: 10,
      seuilDeNotification: 7,
      dureeSanction: 14,
      statut: 'active',
      dateModification: new Date('2024-01-20'),
      dateCreation: new Date('2024-01-12')
    },
    {
      id: 3,
      titre: 'Règle retards répétés',
      description: 'Gestion des retards chroniques. Conversion automatique en absences après accumulation.',
      absencesMax: 8,
      seuilDeNotification: 5,
      dureeSanction: 5,
      statut: 'inactive',
      dateModification: new Date('2024-01-18'),
      dateCreation: new Date('2024-01-08')
    },
    {
      id: 4,
      titre: 'Règle absence examens',
      description: 'Règle spécifique pour les absences lors des évaluations importantes.',
      absencesMax: 3,
      seuilDeNotification: 2,
      dureeSanction: 21,
      statut: 'active',
      dateModification: new Date('2024-01-25'),
      dateCreation: new Date('2024-01-22')
    }
  ]);
  
  // Computed properties
  const filteredRules = computed(() => {
    let filtered = rules.value;
  
    // Filter by search query
    if (searchQuery.value) {
      const query = searchQuery.value.toLowerCase();
      filtered = filtered.filter(rule => 
        rule.titre.toLowerCase().includes(query) ||
        rule.description.toLowerCase().includes(query)
      );
    }
  
    // Filter by status
    if (statusFilter.value) {
      filtered = filtered.filter(rule => rule.statut === statusFilter.value);
    }
  
    return filtered;
  });
  
  const activeRulesCount = computed(() => {
    return rules.value.filter(rule => rule.statut === 'active').length;
  });
  
  const lastModified = computed(() => {
    if (rules.value.length === 0) return 'Aucune';
    const latest = rules.value.reduce((latest, rule) => 
      rule.dateModification > latest.dateModification ? rule : latest
    );
    return formatDate(latest.dateModification);
  });
  
  const totalStudents = computed(() => {
    // This would typically come from an API
    return 1247;
  });
  
  // Methods
  const formatDate = (date) => {
    return new Intl.DateTimeFormat('fr-FR', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    }).format(date);
  };
  
  const handleAddRule = (newRule) => {
    const rule = {
      id: Date.now(),
      ...newRule,
      statut: 'active',
      dateCreation: new Date(),
      dateModification: new Date()
    };
    
    rules.value.unshift(rule);
    showAddRuleModal.value = false;
    
    // Show success notification
    console.log('Nouvelle règle ajoutée:', rule);
  };
  
  const viewRule = (rule) => {
    selectedRule.value = rule;
    showViewModal.value = true;
  };
  
  const editRule = (rule) => {
    selectedRule.value = rule;
    showEditModal.value = true;
  };
  
  const handleEditRule = (updatedRule) => {
    const index = rules.value.findIndex(r => r.id === selectedRule.value.id);
    if (index !== -1) {
      rules.value[index] = {
        ...rules.value[index],
        ...updatedRule,
        dateModification: new Date()
      };
    }
    showEditModal.value = false;
    selectedRule.value = null;
  };
  
  const toggleRuleStatus = (rule) => {
    const newStatus = rule.statut === 'active' ? 'inactive' : 'active';
    const action = newStatus === 'active' ? 'activer' : 'désactiver';
    
    if (confirm(`Êtes-vous sûr de vouloir ${action} cette règle?`)) {
      rule.statut = newStatus;
      rule.dateModification = new Date();
    }
  };
  
  const deleteRule = (rule) => {
    if (confirm(`Êtes-vous sûr de vouloir supprimer la règle "${rule.titre}"? Cette action est irréversible.`)) {
      const index = rules.value.findIndex(r => r.id === rule.id);
      if (index !== -1) {
        rules.value.splice(index, 1);
      }
    }
  };
  
  const exportRules = () => {
    // Implementation for exporting rules
    console.log('Exporting rules...');
    
    // Create CSV content
    const headers = ['Titre', 'Description', 'Absences Max', 'Seuil Notification', 'Durée Sanction', 'Statut'];
    const csvContent = [
      headers.join(','),
      ...rules.value.map(rule => [
        `"${rule.titre}"`,
        `"${rule.description}"`,
        rule.absencesMax,
        rule.seuilDeNotification,
        rule.dureeSanction,
        rule.statut
      ].join(','))
    ].join('\n');
    
    // Download CSV
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'regles-sanction.csv';
    a.click();
    window.URL.revokeObjectURL(url);
  };
  
  onMounted(() => {
    // Load rules from API if needed
    console.log('Rules page mounted');
  });
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