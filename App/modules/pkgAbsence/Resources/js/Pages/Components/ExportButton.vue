<template>
    <button
        @click="exportToCSV"
        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        <Download class="w-4 h-4 mr-2" />
        Exporter les données
    </button>
</template>

<script setup>
import { Download } from 'lucide-vue-next';

const props = defineProps({
    data: {
        type: Array,
        required: true
    }
});

const exportToCSV = () => {
    const headers = Object.keys(props.data[0]);
    const csvContent = [
        headers.join(','),
        ...props.data.map(row => 
            headers.map(header => 
                `"${row[header]}"`
            ).join(',')
        )
    ].join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.setAttribute('download', `absences_${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};
</script> 