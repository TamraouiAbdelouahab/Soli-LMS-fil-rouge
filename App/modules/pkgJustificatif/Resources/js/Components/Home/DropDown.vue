<template>
  <div>
    <div class="relative">
      <button type="button"
        @click="toggleDropdown"
        class="inline-flex justify-between bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
      >
        <span class="mr-2 ">{{ selectedElement }}</span>
        <div class="flex items-center gap-2">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4 ml-2 -mr-1"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
                @click="handleClick(item=null)"
                v-if="selectedElement != null"
                >
                <path
                    fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                />
            </svg>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="w-5 h-5 ml-2 -mr-1"
              viewBox="0 0 20 20"
              fill="currentColor"
              aria-hidden="true"

            >
              <path
                fill-rule="evenodd"
                d="M6.293 9.293a1 1 0 011.414 0L10 11.586l2.293-2.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
        </div>
      </button>

      <div
        v-show="isOpen"
        class="absolute right-0 mt-2 shadow-lg  ring-1 ring-black ring-opacity-5  space-y-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
      >
        <input
          v-model="search"
          type="text"
          placeholder="Search items"
          autocomplete="off"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mb-2"
        />
        <p
          v-for="(item, index) in filteredItems"
          :key="index"
          @click="handleClick(item,item.id)"
          class="block px-4 py-2 text-gray-200 hover:bg-gray-100 hover:text-gray-900 active:bg-blue-100 cursor-pointer rounded-md"
        >
          {{ item.nom + " " + item.prenom }}
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const isOpen = ref(false)
const search = ref('')
const props = defineProps(['apprenants','apprenant_id'])
const emit = defineEmits(['selectElement'])
const selectedElement = ref(props.apprenants.reduce((acc, apprenant) => {
    return apprenant.id == props.apprenant_id
      ? `${apprenant.nom} ${apprenant.prenom}`
      : acc
  }, null)
)

const toggleDropdown = () => {
  isOpen.value = !isOpen.value
}

const filteredItems = computed(() =>
  props.apprenants.filter(apprenant =>
    (apprenant.nom + " " + apprenant.prenom).toLowerCase().includes(search.value.toLowerCase())
  )
)
function handleClick(item,id) {
    if(item == null){
        selectedElement.value = null;
        emit('selectElement',null);
    }
    else{
        selectedElement.value = item.nom + " " + item.prenom;
        emit('selectElement',id);
    }
  isOpen.value = false
}


</script>
