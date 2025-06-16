<template>

<!-- <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
Toggle modal
</button> -->

<div
class="fixed top-0 right-0 z-50 flex justify-center items-center w-full p-4 h-screen animate-scaleIn"
>
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <button type="button" @click="emit('closeConfirmation')" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <!-- <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3> -->
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">tu es sûr le point de supprimer la justification</h3>
                <button data-modal-hide="popup-modal" @click="emit('confirm')" type="button" class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                   oui, je suis sûr
                </button>
                <button data-modal-hide="popup-modal" type="button" @click="emit('cancel')"
                        class="py-2.5 px-5 ms-3 text-sm font-bold text-blue-500 focus:outline-none bg-white rounded-lg  hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-700 dark:text-blue-400  dark:hover:text-blue-500 dark:hover:bg-gray-600">
                    Non
                </button>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>
   const emit = defineEmits(['closeConfirmation','confirm','cancel'])
</script>


<style scoped>

@keyframes scaleIn {
  0% {
    top: -5%;
    transform: scale(0.8);
    opacity: 0;
  }
  100% {
    top:0%;
    transform: scale(1);
    opacity: 1;
  }

}
.animate-scaleIn {
  animation: scaleIn .3s ease-out forwards;
}


</style>

    