<template>
    <AuthenticatedLayout>
        <div class="p-6">
            <!-- Header with Export -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Tableau de Bord des Absences</h1>
                <ExportButton :data="exportData" />
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <SummaryCard
                    title="Total des absences"
                    :value="totalAbsences"
                    trend="Total général"
                    color="blue"
                    icon="Database"
                />
                
                <SummaryCard
                    title="Absences du jour"
                    :value="todayAbsences"
                    trend="Aujourd'hui"
                    color="red"
                    icon="Clock"
                />

                <SummaryCard
                    title="Absences hebdomadaires"
                    :value="weeklyAbsences"
                    trend="Cette semaine"
                    color="orange"
                    icon="Calendar"
                />

                <SummaryCard
                    title="Absences mensuelles"
                    :value="monthlyAbsences"
                    trend="Ce mois"
                    color="green"
                    icon="CalendarDays"
                />
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Weekly Chart -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Évolution hebdomadaire</h2>
                    <div class="h-64">
                        <LineChart :chartData="weeklyChart" />
                    </div>
                </div>

                <!-- Monthly Chart -->
                <div class="bg-white rounded-lg shadow p-4">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Évolution mensuelle</h2>
                    <div class="h-64">
                        <LineChart :chartData="monthlyChart" />
                    </div>
                </div>
            </div>

            <!-- Lists Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Absences -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Absences récentes</h2>
                        <button class="text-sm text-blue-600 hover:text-blue-800">
                            Voir tout
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Séance</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé le</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="absence in recentAbsences" :key="absence.id" class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm text-gray-900">#{{ absence.id }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500">{{ absence.date }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500">#{{ absence.seance_id }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500">{{ absence.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top Absentees -->
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Top Absences du Mois</h2>
                        <button class="text-sm text-blue-600 hover:text-blue-800">
                            Détails
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div v-for="record in topAbsentees" :key="record.apprenant_id" 
                             class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">
                                        Apprenant #{{ record.apprenant_id }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                    {{ record.total }} absences
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@core/Layouts/AuthenticatedLayout.vue';
import SummaryCard from './Components/SummaryCard.vue';
import LineChart from './Components/LineChart.vue';
import ExportButton from './Components/ExportButton.vue';
import { Database, Clock, Calendar, CalendarDays } from 'lucide-vue-next';

const props = defineProps({
    totalAbsences: Number,
    todayAbsences: Number,
    weeklyAbsences: Number,
    monthlyAbsences: Number,
    weeklyChart: Object,
    monthlyChart: Object,
    recentAbsences: Array,
    topAbsentees: Array,
    exportData: Array
});
</script>

<style scoped>
.chart-container {
    position: relative;
    height: 100%;
}
</style> 