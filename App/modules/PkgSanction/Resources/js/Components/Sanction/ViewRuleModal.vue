<template>
    <!-- Modal Overlay -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeModal">
        <!-- Modal Container -->
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 xl:w-2/5 shadow-lg rounded-md bg-white"
            @click.stop>
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                    <Eye class="h-5 w-5 mr-2 text-light-blue-800" />
                    Détails de la Règle
                </h3>
                <button @click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <X class="h-6 w-6" />
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mt-4 mb-4 max-h-96 overflow-y-auto space-y-6">
                <!-- Basic Information -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">Informations Générales</h4>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Titre</label>
                                <p class="text-sm text-gray-900">{{ rule.titre }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Type de Sanction</label>
                                <p class="text-sm text-gray-900">{{ rule.sanction_type }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-500">Description</label>
                            <p class="text-sm text-gray-900">{{ rule.description }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Statut</label>
                                <span :class="[
                                    'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                    rule.est_actif === 1
                                        ? 'bg-teal-100 text-teal-800'
                                        : 'bg-red-orange-100 text-red-orange-800'
                                ]">
                                    {{ rule.est_actif === 1 ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date de création</label>
                                <p class="text-sm text-gray-900">{{ formatDate(rule.created_at) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parameters -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">Paramètres</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-teal-50 rounded-lg p-4 text-center">
                            <Users class="h-8 w-8 text-teal-800 mx-auto mb-2" />
                            <p class="text-2xl font-bold text-teal-900">{{ rule.absences_max }}</p>
                            <p class="text-sm text-teal-800">Absences Maximum</p>
                        </div>
                        <div class="bg-teal-50 rounded-lg p-4 text-center">
                            <Bell class="h-8 w-8 text-teal-800 mx-auto mb-2" />
                            <p class="text-2xl font-bold text-teal-800">{{ rule.seuil_de_notification }}</p>
                            <p class="text-sm text-teal-800">Seuil de Notification</p>
                        </div>
                        <div class="bg-teal-50 rounded-lg p-4 text-center">
                            <Calendar class="h-8 w-8 text-teal-800 mx-auto mb-2" />
                            <p class="text-2xl font-bold text-teal-800">{{ rule.duree_sanction }}</p>
                            <p class="text-sm text-teal-800">Durée (jours)</p>
                        </div>
                    </div>
                </div>

                <!-- Timeline -->
                <div>
                    <h4 class="text-lg font-medium text-gray-900 mb-3">Fonctionnement</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <span class="text-yellow-800 text-sm font-medium">1</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">
                                        <strong>Notification à {{ rule.seuil_de_notification }} absence{{
                                            rule.seuil_de_notification > 1 ? 's' : '' }}</strong>
                                    </p>
                                    <p class="text-xs text-gray-500">Avertissement automatique envoyé</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <span class="text-red-800 text-sm font-medium">2</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-gray-900">
                                        <strong>Sanction à {{ rule.absences_max }} absence{{ rule.absences_max > 1 ? 's'
                                            :
                                            '' }}</strong>
                                    </p>
                                    <p class="text-xs text-gray-500">Application de la sanction pendant {{
                                        rule.duree_sanction }} jour{{ rule.duree_sanction > 1 ? 's' : '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end pt-4 border-t border-gray-200">
                <button @click="closeModal"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Eye, X, Users, Bell, Calendar } from 'lucide-vue-next';

// Props
const props = defineProps({
    rule: {
        type: Object,
        required: true
    },
    formatDate: {
        type: Function,
        required: true
    }
});

// Emits
const emit = defineEmits(['close']);

// Methods
const closeModal = () => {
    emit('close');
};

</script>

<style scoped>
/* Modal animation */
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.relative {
    animation: modalSlideIn 0.3s ease-out;
}
</style>