<template>
  <AuthenticatedLayout>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-4 md:p-6">
      <!-- Header Section -->
      <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
          <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
              Tableau de bord des Absences
            </h1>
            <p class="text-gray-600 text-lg">
              Vue d'ensemble et analytics en temps réel
            </p>
          </div>
          <div class="mt-4 lg:mt-0 flex items-center space-x-4">
            <div class="bg-white rounded-lg px-4 py-2 shadow-sm border">
              <span class="text-sm text-gray-500">Dernière mise à jour:</span>
              <span class="text-sm font-medium text-gray-900 ml-1">{{ formatDateTime(new Date()) }}</span>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
              </svg>
              Exporter
            </button>
          </div>
        </div>
      </div>

      <!-- Key Performance Indicators -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <EnhancedKPICard 
          title="Absences Aujourd'hui"
          :value="totalAbsencesToday ?? 0"
          :previousValue="yesterdayAbsences ?? 0"
          icon="UserX"
          color="red"
          :trend="calculateTrend(totalAbsencesToday, yesterdayAbsences)"
          description="vs hier"
        />
        <EnhancedKPICard 
          title="Taux de Présence"
          :value="`${(100 - (globalAbsenceRate ?? 0)).toFixed(1)}%`"
          :previousValue="previousPresenceRate"
          icon="Users"
          color="green"
          :trend="calculateTrend(100 - globalAbsenceRate, previousPresenceRate)"
          description="vs semaine dernière"
        />
        <EnhancedKPICard 
          title="Absences Justifiées"
          :value="`${absenceStats?.justified_percentage ?? 0}%`"
          :previousValue="previousJustifiedRate"
          icon="CheckCircle"
          color="blue"
          :trend="calculateTrend(absenceStats?.justified_percentage, previousJustifiedRate)"
          description="du total"
        />
        <EnhancedKPICard 
          title="Alertes Critiques"
          :value="criticalAlerts ?? 0"
          :previousValue="previousCriticalAlerts"
          icon="AlertTriangle"
          color="orange"
          :trend="calculateTrend(criticalAlerts, previousCriticalAlerts)"
          description="apprenants à risque"
        />
      </div>

      <!-- Quick Stats Row -->
      <div class="grid grid-cols-2 lg:grid-cols-6 gap-4 mb-8">
        <QuickStatCard 
          label="Total Absences"
          :value="absenceStats?.total ?? 0"
          icon="Calendar"
          color="gray"
        />
        <QuickStatCard 
          label="Justifiées"
          :value="absenceStats?.justified ?? 0"
          icon="Check"
          color="green"
        />
        <QuickStatCard 
          label="Non Justifiées"
          :value="absenceStats?.unjustified ?? 0"
          icon="X"
          color="red"
        />
        <QuickStatCard 
          label="Sanctionnées"
          :value="absenceStats?.sanctioned ?? 0"
          icon="Flag"
          color="orange"
        />
        <QuickStatCard 
          label="Groupes Actifs"
          :value="activeGroups ?? 0"
          icon="Users"
          color="blue"
        />
        <QuickStatCard 
          label="Séances Aujourd'hui"
          :value="todaySessions ?? 0"
          icon="Clock"
          color="purple"
        />
      </div>

      <!-- Charts and Analytics Section -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Main Chart -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Tendance des Absences</h2>
            <div class="flex items-center space-x-2">
              <button 
                v-for="period in ['7j', '30j', '90j']" 
                :key="period"
                @click="selectedPeriod = period"
                :class="[
                  'px-3 py-1 rounded-lg text-sm font-medium transition-colors duration-200',
                  selectedPeriod === period 
                    ? 'bg-blue-100 text-blue-700' 
                    : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'
                ]"
              >
                {{ period }}
              </button>
            </div>
          </div>
          <div class="h-80">
            <AdvancedLineChart :chartData="trendChartData" :period="selectedPeriod" />
          </div>
        </div>

        <!-- Absence Distribution -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
          <h2 class="text-xl font-bold text-gray-900 mb-6">Répartition des Absences</h2>
          <div class="h-80">
            <DonutChart :chartData="distributionChartData" />
          </div>
          <div class="mt-4 space-y-2">
            <div class="flex items-center justify-between text-sm">
              <div class="flex items-center">
                <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                <span>Justifiées</span>
              </div>
              <span class="font-medium">{{ absenceStats?.justified ?? 0 }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
              <div class="flex items-center">
                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                <span>Non justifiées</span>
              </div>
              <span class="font-medium">{{ absenceStats?.unjustified ?? 0 }}</span>
            </div>
            <div class="flex items-center justify-between text-sm">
              <div class="flex items-center">
                <div class="w-3 h-3 bg-orange-500 rounded-full mr-2"></div>
                <span>Sanctionnées</span>
              </div>
              <span class="font-medium">{{ absenceStats?.sanctioned ?? 0 }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Detailed Analytics -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Groups Analysis -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Analyse par Groupe</h2>
            <button class="text-blue-600 hover:text-blue-700 text-sm font-medium">
              Voir tout
            </button>
          </div>
          <div class="space-y-4">
            <div v-for="(group, index) in topGroups?.slice(0, 5)" :key="group.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
              <div class="flex items-center">
                <div :class="[
                  'w-10 h-10 rounded-full flex items-center justify-center text-white font-bold mr-4',
                  getGroupColor(index)
                ]">
                  {{ index + 1 }}
                </div>
                <div>
                  <h3 class="font-semibold text-gray-900">{{ group.nom }}</h3>
                  <p class="text-sm text-gray-500">{{ group.total_apprenants }} apprenants</p>
                </div>
              </div>
              <div class="text-right">
                <div class="text-lg font-bold text-gray-900">{{ group.total }}</div>
                <div class="text-sm text-gray-500">absences</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Time Analysis -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
          <h2 class="text-xl font-bold text-gray-900 mb-6">Analyse Temporelle</h2>
          <div class="h-64">
            <HeatmapChart :chartData="timeAnalysisData" />
          </div>
        </div>
      </div>

      <!-- Alerts and Recommendations -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Critical Alerts -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
          <div class="flex items-center mb-6">
            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
              <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
              </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Alertes Critiques</h2>
          </div>
          <div class="space-y-4">
            <div v-for="alert in criticalAlertsData" :key="alert.id" class="flex items-start p-4 bg-red-50 rounded-xl border border-red-200">
              <div class="flex-shrink-0 w-2 h-2 bg-red-500 rounded-full mt-2 mr-3"></div>
              <div class="flex-1">
                <h3 class="font-semibold text-red-900">{{ alert.title }}</h3>
                <p class="text-sm text-red-700 mt-1">{{ alert.description }}</p>
                <div class="flex items-center mt-2">
                  <span class="text-xs text-red-600 bg-red-100 px-2 py-1 rounded-full">
                    {{ alert.severity }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Top Absent Students -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Apprenants à Surveiller</h2>
            <span class="text-sm text-gray-500">Ce mois</span>
          </div>
          <div class="space-y-4">
            <div v-for="(student, index) in topAbsentStudents" :key="student.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
              <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                  {{ getInitials(student) }}
                </div>
                <div>
                  <h3 class="font-semibold text-gray-900">{{ student.nom }} {{ student.prenom }}</h3>
                  <p class="text-sm text-gray-500">{{ student.groupe_nom }}</p>
                </div>
              </div>
              <div class="text-right">
                <div class="text-lg font-bold text-red-600">{{ student.total_absences }}</div>
                <div class="text-sm text-gray-500">absences</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Performance Metrics -->
      <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Métriques de Performance</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <PerformanceMetric 
            title="Taux de Justification"
            :value="absenceStats?.justified_percentage ?? 0"
            unit="%"
            :target="85"
            color="blue"
            description="Objectif: 85%"
          />
          <PerformanceMetric 
            title="Temps Moyen de Justification"
            :value="averageJustificationTime ?? 0"
            unit="h"
            :target="24"
            color="green"
            description="Objectif: < 24h"
          />
          <PerformanceMetric 
            title="Taux de Récidive"
            :value="recurrenceRate ?? 0"
            unit="%"
            :target="15"
            color="orange"
            description="Objectif: < 15%"
            :inverse="true"
          />
          <PerformanceMetric 
            title="Satisfaction Suivi"
            :value="followUpSatisfaction ?? 0"
            unit="%"
            :target="90"
            color="purple"
            description="Objectif: 90%"
          />
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue'

// Import enhanced components
import EnhancedKPICard from './Components/EnhancedKPICard.vue'
import QuickStatCard from './Components/QuickStatCard.vue'
import PerformanceMetric from './Components/PerformanceMetric.vue'

const props = defineProps({
  totalAbsencesToday: Number,
  yesterdayAbsences: Number,
  learnersAbsentToday: Number,
  globalAbsenceRate: Number,
  previousPresenceRate: Number,
  previousJustifiedRate: Number,
  criticalAlerts: Number,
  previousCriticalAlerts: Number,
  activeGroups: Number,
  todaySessions: Number,
  topGroups: Array,
  topSessions: Array,
  weeklyRecap: Array,
  monthlyRecap: Array,
  frequentAbsentees: Array,
  absenceStats: Object,
  topAbsentStudents: Array,
  criticalAlertsData: Array,
  timeAnalysisData: Object,
  averageJustificationTime: Number,
  recurrenceRate: Number,
  followUpSatisfaction: Number,
})

// Reactive data
const selectedPeriod = ref('30j')

// Computed properties
const trendChartData = computed(() => {
  const data = selectedPeriod.value === '7j' ? props.weeklyRecap : props.monthlyRecap
  if (!data || !data.length) {
    return { labels: [], datasets: [] }
  }

  return {
    labels: data.map(item => {
      if (selectedPeriod.value === '7j') {
        const date = new Date(item.day)
        return date.toLocaleDateString('fr-FR', { weekday: 'short', day: 'numeric' })
      }
      return `Semaine ${item.week}`
    }),
    datasets: [
      {
        label: 'Absences',
        data: data.map(item => item.total),
        borderColor: '#3B82F6',
        backgroundColor: 'rgba(59, 130, 246, 0.1)',
        borderWidth: 3,
        tension: 0.4,
        fill: true,
        pointBackgroundColor: '#3B82F6',
        pointBorderColor: '#ffffff',
        pointBorderWidth: 2,
        pointRadius: 6,
      },
      {
        label: 'Justifiées',
        data: data.map(item => item.justified || 0),
        borderColor: '#10B981',
        backgroundColor: 'rgba(16, 185, 129, 0.1)',
        borderWidth: 2,
        tension: 0.4,
        fill: false,
      }
    ],
  }
})

const distributionChartData = computed(() => {
  if (!props.absenceStats) {
    return { labels: [], datasets: [] }
  }

  return {
    labels: ['Justifiées', 'Non justifiées', 'Sanctionnées'],
    datasets: [{
      data: [
        props.absenceStats.justified || 0,
        props.absenceStats.unjustified || 0,
        props.absenceStats.sanctioned || 0
      ],
      backgroundColor: [
        '#10B981',
        '#EF4444',
        '#F59E0B'
      ],
      borderWidth: 0,
      hoverOffset: 4
    }]
  }
})

// Helper functions
function calculateTrend(current, previous) {
  if (!previous || previous === 0) return 0
  return ((current - previous) / previous * 100).toFixed(1)
}

function formatDateTime(date) {
  return date.toLocaleDateString('fr-FR', {
    day: 'numeric',
    month: 'short',
    hour: '2-digit',
    minute: '2-digit'
  })
}

function getGroupColor(index) {
  const colors = [
    'bg-red-500',
    'bg-orange-500',
    'bg-yellow-500',
    'bg-green-500',
    'bg-blue-500'
  ]
  return colors[index] || 'bg-gray-500'
}

function getInitials(student) {
  if (!student) return '??'
  const nom = student.nom?.charAt(0) || ''
  const prenom = student.prenom?.charAt(0) || ''
  return (nom + prenom).toUpperCase()
}
</script>
