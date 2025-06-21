<template>
  <div
  v-if="show"
  >
    <form  @submit.prevent="addReason" method="POST"
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
                <label  for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Code
                </label>
                <input type="text" id="code" name="code" v-model="form.code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                        placeholder="MAL" required />
                <small class="text-red-500" v-if="form.errors.code">{{ form.errors.code }}</small>
            </div>
            <div class="w-1/2">
                <label  for="libelle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                  Libelle
                </label>
                <input  type="text" id="libelle" name="libelle" v-model="form.libelle" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
                        placeholder="Maladie" required />
                <small class="text-red-500" v-if="form.errors.libelle">{{ form.errors.libelle }}</small>
            </div>
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
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';
    const props = defineProps(['show'])
    const emit = defineEmits(['close','closeConfirmation','openConfirmation']);

    const animatingOut = ref(false);
    const isSubmitting = ref(false);
    const form = useForm({
    code: "",
    libelle: "",
    description: "",
    });
    const addReason = () => {
        if (isSubmitting.value) return;
            isSubmitting.value = true;
        form.post(route('reasons.store'), {
            onSuccess: () => {
                form.reset();
                animatingOut.value = true;
                emit('close');
                emit('openConfirmation');
                setTimeout(() => {
                    emit('closeConfirmation');
                }, 1000);
                animatingOut.value = false;
                isSubmitting.value = false;
            },
            onError: () => {
                isSubmitting.value = false;
                console.log(form.errors)
            },
            onFinish: () => {
                isSubmitting.value = false;
            }
            });
        };
    function closePopup() {
        animatingOut.value = true;
        setTimeout(() => {
        emit('close');
        animatingOut.value = false;
        }, 200);
    }
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
