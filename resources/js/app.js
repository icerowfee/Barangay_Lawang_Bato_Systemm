import './bootstrap';
// import Alpine from "alpinejs";
import Alpine from 'alpinejs';

import Chart from 'chart.js/auto';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.css';
import ChartDataLabels from 'chartjs-plugin-datalabels';

Chart.register(ChartDataLabels);
window.Chart = Chart;
// window.Alpine = Alpine;
// Alpine.start();

// import focus from '@alpinejs/focus';

// Optional Alpine plugin
// Alpine.plugin(focus);


// 🟢 Start Alpine only after Livewire is ready
document.addEventListener('livewire:load', () => {
    window.Alpine = Alpine;
    Alpine.start();

    // Initialize TomSelects on initial load
    initializeTomSelects();
});

// 🟢 Helper function for initializing TomSelect
function initializeTomSelects() {
    // Regular dropdowns
    document.querySelectorAll('.tom-select').forEach((el) => {
        if (!el.tomselect) {
            new TomSelect(el, {
                create: true,
                persist: false,
                maxItems: 1,
                placeholder: 'Choose or type purpose...',
            });
        }
    });

    // Rejection reason dropdowns
    document.querySelectorAll('.tom-select-for-rejection').forEach((el) => {
        if (!el.tomselect) {
            new TomSelect(el, {
                create: true,
                persist: false,
                maxItems: 1,
                placeholder: 'Choose or type rejection purpose...',
            });
        }
    });
}

// 🟢 Re-initialize TomSelect after Livewire updates DOM
document.addEventListener('livewire:update', () => {
    initializeTomSelects();
});

// 🟢 (Optional) Re-initialize after navigation or polling
document.addEventListener('livewire:navigated', () => {
    initializeTomSelects();
});

// 🟢 Initialize also on DOMContentLoaded (just in case Livewire is not ready yet)
document.addEventListener('DOMContentLoaded', () => {
    initializeTomSelects();
});

document.addEventListener('livewire:afterDomUpdate', () => {
    initializeTomSelects();
});

// 🔔 Echo channel example
window.Echo.channel('new-document-request').listen('NewDocumentRequest', (e) => {
    const notification = document.createElement('div');
    notification.className = 'notification is-info';
    notification.innerHTML = `<button class="delete"></button>${e.message}`;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 5000);

    console.log('NewDocumentRequest event received:', e);
});
