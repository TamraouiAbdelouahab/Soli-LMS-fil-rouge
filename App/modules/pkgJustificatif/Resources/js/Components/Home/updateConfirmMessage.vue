<template>

<div

class="fixed top-0 right-0 z-50 flex justify-end items-start w-full p-4 h-screen animate-scaleIn">
    <div class="relative p-4 w-full max-w-md max-h-full ">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <button type="button" @click="emit('closeUpdateConfirmation')" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center ">
                <!-- <svg class="mx-auto mb-4 text-gray-500 w-12 h-12 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13l2 2l4-4M15 4H9m12 4H3m3 0v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8" />
                </svg> -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-24 h-24 text-green-500 mx-auto mb-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5h2m2 0h.01M6 19h.01M3 13h.01M14.828 14.828a4 4 0 010-5.656L17 9l2 2-2.172 2.172a4 4 0 01-5.656 0zM4 20h4l10-10-4-4L4 16v4z"/>
                </svg>

                <!-- <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3> -->
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Le justificatif a été modifié avec succès.</h3>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>
   const emit = defineEmits(['closeUpdateConfirmation'])
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
