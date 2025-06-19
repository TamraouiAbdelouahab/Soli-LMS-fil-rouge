<template>
<div

class="fixed top-0 right-0 z-50 flex justify-end items-start w-full p-4 h-screen animate-scaleIn">
    <div class="relative p-4 w-full max-w-md max-h-full ">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <button type="button" @click="emit('closeDeleteConfirmation')" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center ">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-12 h-12 text-red-600 mx-auto mb-4"
                fill="none"
                viewBox="0 0 24 24" 
                stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <!-- <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3> -->
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                    Impossible de supprimer cette raison car elle est utilisée dans des justifications.
                </h3>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>
   const emit = defineEmits(['closeDeleteConfirmation'])
</script>
<style scoped>
@keyframes scaleIn {
  0% {
    top: 5%;
    transform: scale(0.9);
    opacity: 0;
  }
  100% {
    top:0%;
    transform: scale(1);
    opacity: 1;
  }
}

.animate-scaleIn {
  animation: scaleIn 0.3s ease-out forwards;
}
</style>
