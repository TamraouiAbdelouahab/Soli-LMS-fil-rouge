<template>
  <div
  v-if="show"
  >
    <form  @submit.prevent="updateJustification" method="POST"
        enctype="multipart/form-data"
        class="fixed inset-0 py-8 flex items-center justify-center bg-black bg-opacity-80 z-40 "
    >
      <div :class="['bg-white animate-popup m-4 p-6 rounded-lg shadow-xl w-3/4 overflow-y-auto max-h-[calc(100vh-2vh)] dark:bg-gray-800',animatingOut ? 'animate-popupOut' : 'animate-popupIn']">
        <div class="flex justify-between gap-4 w-full items-center">
            <h2 class="text-xl font-semibold mb-4 dark:text-white">Ajouter un justification</h2>
            <div>
            <button type="button" @click="closePopup()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        </div>
        <div class="flex justify-between gap-4 w-full">
            <div class="w-1/2">
                <label  for="dateDebut" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Date debut
                </label>
                <input type="date" id="dateDebut" name="dateDebut" v-model="form.dateDebut" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                        placeholder="01/01/2025" required />
                <small class="text-red-500" v-if="form.errors.dateDebut">{{ form.errors.dateDebut }}</small>
            </div>
            <div class="w-1/2">
                <label  for="dateFin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Date fin
                </label>
                <input  type="date" id="dateFin" name="dateFin" v-model="form.dateFin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                        placeholder="02/01/2025" required />
                <small class="text-red-500" v-if="form.errors.dateFin">{{ form.errors.dateFin }}</small>
            </div>
        </div>
        <div class="flex justify-between gap-4 w-full">
          <div class="w-1/2">
              <label  for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white w-full">
                status
              </label>
              <select name="status" v-model="form.status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
                <option v-for="[key, status] in Object.entries(statuses)" :value="key" :key="key">{{status}}</option>
              </select>
              <small class="text-red-500" v-if="form.errors.status">{{ form.errors.status }}</small>
          </div>
          <div class="w-1/2">
              <label for="raison" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                raison
              </label>
              <div class="flex justify-between gap-4 w-full items-start">
                <select name="raison" v-model="form.raison" id="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
                  <option v-for="reason in props.reasons" :value="reason.id" :key="reason.id">{{reason.libelle}}</option>
                </select>
                <small class="text-red-500" v-if="form.errors.raison">{{ form.errors.raison }}</small>
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
              <select name="apprenant" id="groupe" v-model="form.apprenant" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2">
                <option v-for="apprenant in apprenantsDuGroupe" :value="apprenant.id" :key="apprenant.id">{{apprenant.nom + " " + apprenant.prenom}}</option>
              </select>
              <small class="text-red-500" v-if="form.errors.apprenant">{{ form.errors.apprenant }}</small>
          </div>
        </div>
        <div>
            <label  for="fichier" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Fichier
            </label>
            <input  type="file" name="fichier" @change="handleFileUpload" id="fichier" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                    placeholder=".png,.jpg,.pdf" required />
            <small class="text-red-500" v-if="form.errors.fichier">{{ form.errors.fichier }}</small>
        </div>
        <div>
            <label  for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Description
            </label>
            <textarea name="description" v-model="form.description" id="description" placeholder="optional"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
            ></textarea>
            <small class="text-red-500" v-if="form.errors.description">{{ form.errors.description }}</small>
        </div>
        <div class="flex items-center justify-end">
            <button
                type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
            >
              Ajouter
            </button>
        </div>
      </div>
    </form>
  </div>
</template>



<script setup>
    import { computed } from 'vue';
    import { ref,watch  } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    const props = defineProps(['show','reasons','groups','justification'])
    const emit = defineEmits(['close','closeAddConfirmationVisible','openAddConfirmationVisible']);
    const statuses = ref({
    "EN_ATTENTE": "en attente",
    "ACCEPTE": "accepte",
    "REJETE": "rejete",
    })
    const groupe = ref(props.groups[0].id);
    const apprenantsDuGroupe =ref( computed(() => {
    const selectedGroup = props.groups.find(g => g.id === groupe.value);
    return selectedGroup ? selectedGroup.apprenants : [];
    }));
    const animatingOut = ref(false);
    const isSubmitting = ref(false);
    const form = useForm({
    dateDepot: new Date().toISOString().split('T')[0],
    dateDebut: props.justification.dateDebut || '',
    dateFin : props.justification.dateFin || '',
    description : props.justification.description || '',
    status: props.justification.status || 'EN_ATTENTE',
    raison: props.justification.raison?.id || props.reasons[0].id,
    apprenant: props.justification.apprenant?.id || apprenantsDuGroupe.value[0]?.id,
    fichier: props.justification.fichier || null,
    });

    const updateJustification = () => {
        if (isSubmitting.value) return;
            isSubmitting.value = true;

         form.post(route('Justificatifs.update', props.justification.id), {
            forceFormData: true,
            _method: 'put',
            onSuccess: () => {
                animatingOut.value = true;
                emit('close');
                animatingOut.value = false;
                isSubmitting.value = false;
            },
            onError: () => {
                isSubmitting.value = false;
            },
            onFinish: () => {
                isSubmitting.value = false;
            }
            });
        };
    function handleFileUpload(event) {
        form.fichier = event.target.files[0]
    }
    function closePopup() {
        animatingOut.value = true;
        setTimeout(() => {
        emit('close');
        animatingOut.value = false;
        }, 200);
    }
    watch(() => props.justification, (newJustification) => {
    if (newJustification) {
        form.dateDepot = newJustification.dateDepot || new Date().toISOString().split('T')[0];
        form.dateDebut = newJustification.dateDebut || '';
        form.dateFin = newJustification.dateFin || '';
        form.description = newJustification.description || '';
        form.status = newJustification.status || 'EN_ATTENTE';
        form.raison = newJustification.raison?.id || props.reasons[0].id;
        form.apprenant = newJustification.apprenant?.id || apprenantsDuGroupe.value[0]?.id;
        form.fichier = newJustification.fichier || null;
    }
    },
    { immediate: true }
    )
</script>


<style scoped>
@keyframes popupIn {
  0% {
    transform: scale(0.75);
    opacity: 0;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

.animate-popupIn {
  animation: popupIn 0.3s ease-out forwards;
}
@keyframes popupOut {
  0% {
    transform: scale(1);
    opacity: 1;

  }
  100% {
    transform: scale(0.75);
    opacity: 0;
  }
}
.animate-popupOut {
  animation: popupOut 0.3s ease-out forwards;
}
</style>
