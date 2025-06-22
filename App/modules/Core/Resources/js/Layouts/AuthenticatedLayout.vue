<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@core/Components/ApplicationLogo.vue';
import Dropdown from '@core/Components/Dropdown.vue';
import DropdownLink from '@core/Components/DropdownLink.vue';
import NavLink from '@core/Components/NavLink.vue';
import ResponsiveNavLink from '@core/Components/ResponsiveNavLink.vue';
import {
    Menu,
    X,
    ChevronDown,
    Bell,
    Search,
    User,
    LogOut,
    Home,
    BarChart2,
    FileText,
    Settings,
    ChevronRight,
    ChevronLeft,
    Gavel
} from 'lucide-vue-next';

const dashboardExpanded = ref(false)
const sanctionExpanded = ref(false)
const justificatifsExpanded = ref(false)
const absencesExpanded = ref(false)

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(true);
const isMobile = ref(false);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
};

const checkScreenSize = () => {
    isMobile.value = window.innerWidth < 1024;
    if (isMobile.value) {
        sidebarOpen.value = false;
    }
};

onMounted(() => {
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);
});

onUnmounted(() => {
    window.removeEventListener('resize', checkScreenSize);
});
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Top Navigation Bar -->
        <nav class="fixed z-10 w-full bg-white shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Left side - Logo and toggle -->
                    <div class="flex items-center">
                        <button @click="toggleSidebar"
                            class="mr-4 rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-600 focus:outline-none">
                            <Menu v-if="!sidebarOpen || isMobile" class="h-6 w-6" />
                            <X v-else class="h-6 w-6" />
                        </button>

                        <Link :href="route('dashboard')" class="flex items-center">
                        <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800 lg:ps-4" />
                        </Link>
                    </div>

                    <!-- Center - Search -->
                    <!-- <div class="hidden flex-1 px-8 lg:flex lg:max-w-md">
                        <div class="relative w-full">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <Search class="h-5 w-5 text-gray-400" />
                            </div>
                            <input type="text"
                                class="block w-full rounded-md border-0 py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                placeholder="Rechercher..." />
                        </div>
                    </div> -->

                    <!-- Right side - Notifications and Profile -->
                    <div class="flex items-center">
                        <button
                            class="mr-4 rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-600 focus:outline-none">
                            <Bell class="h-6 w-6" />
                        </button>

                        <!-- Profile Dropdown -->
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex items-center rounded-full border border-transparent bg-white p-1 text-sm font-medium text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none">
                                    <div class="mr-2 h-8 w-8 overflow-hidden rounded-full bg-gray-200">
                                        <User class="h-full w-full p-1 text-gray-600" />
                                    </div>
                                    <div class="hidden md:block">
                                        {{ $page.props.auth.user.name }}
                                    </div>
                                    <ChevronDown class="ml-1 h-4 w-4" />
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    <div class="flex items-center">
                                        <User class="mr-2 h-4 w-4" />
                                        <span>Profil</span>
                                    </div>
                                </DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    <div class="flex items-center">
                                        <LogOut class="mr-2 h-4 w-4" />
                                        <span>Se déconnecter</span>
                                    </div>
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0 lg:w-20',
            'fixed inset-y-0 z-20 flex w-64 flex-col bg-white shadow-lg transition-all duration-300 ease-in-out'
        ]">
            <!-- Sidebar header -->
            <div class="flex h-16 items-center justify-between border-b px-4">
                <Link :href="route('dashboard')" class="flex items-center" v-show="sidebarOpen">
                <ApplicationLogo class="block h-8 w-auto fill-current text-gray-800" />
                <span class="ml-3 text-lg font-semibold text-gray-800">Soli-LMS</span>
                </Link>
                <button @click="toggleSidebar"
                    class="lg:flex hidden rounded-md p-1.5 text-gray-500 hover:bg-gray-100 hover:text-gray-600 focus:outline-none">
                    <ChevronLeft v-if="sidebarOpen" class="h-5 w-5" />
                    <ChevronRight v-else class="h-5 w-5" />
                </button>
            </div>

            <!-- Sidebar content -->
            <div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-4">
                <nav class="mt-5 flex-1 space-y-1 px-2">
                    <!-- Dashboard Parent -->
                    <button @click="dashboardExpanded = !dashboardExpanded" :class="[
                        route().current('sanction.dashboard') || route().current('Justificatifs.dashboard') || route().current('absence.dashboard')
                            ? 'bg-blue-50 text-teal-700'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                        sidebarOpen ? 'justify-start' : 'justify-center',
                        'w-full flex items-center rounded-md px-2 py-2 text-sm font-medium focus:outline-none transition'
                    ]">
                        <Home :class="[
                            route().current('sanction.dashboard') || route().current('Justificatifs.dashboard') || route().current('absence.dashboard')
                                ? 'text-teal-700'
                                : 'text-gray-500 group-hover:text-gray-500',
                            'mr-3 h-5 w-5 flex-shrink-0'
                        ]" />
                        <span v-if="sidebarOpen">Tableaux de bord</span>
                        <ChevronRight v-if="!dashboardExpanded && sidebarOpen" class="ml-auto h-4 w-4 text-gray-400" />
                        <ChevronDown v-if="dashboardExpanded && sidebarOpen" class="ml-auto h-4 w-4 text-gray-400" />
                    </button>

                    <!-- Sublinks -->
                    <div v-show="dashboardExpanded" class="ml-8 space-y-1" v-if="sidebarOpen">
                        <!-- Page 1 -->
                        <Link :href="route('sanction.dashboard')" :class="[
                            route().current('sanction.dashboard') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                        Sanctions
                        </Link>

                        <!-- Page 2 -->
                        <Link :href="route('Justificatifs.dashboard')" :class="[
                            route().current('Justificatifs.dashboard') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                        Justificatifs
                        </Link>

                        <!-- Page 3 -->
                        <Link :href="route('absence.dashboard')" :class="[
                            route().current('absence.dashboard') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                        Absences
                        </Link>
                    </div>

                    <!-- Sanction Parent -->
                    <button @click="sanctionExpanded = !sanctionExpanded" :class="[
                        route().current('sanction.rules.index') || route().current('sanction.tracking.index')
                            ? 'bg-blue-50 text-teal-700'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                        sidebarOpen ? 'justify-start' : 'justify-center',
                        'w-full flex items-center rounded-md px-2 py-2 text-sm font-medium focus:outline-none transition'
                    ]">
                        <Gavel :class="[
                            route().current('sanction.rules.index') || route().current('sanction.tracking.index')
                                ? 'text-teal-700'
                                : 'text-gray-500 group-hover:text-gray-500',
                            'mr-3 h-5 w-5 flex-shrink-0'
                        ]" />
                        <span v-if="sidebarOpen">Sanctions</span>
                        <ChevronRight v-if="!sanctionExpanded && sidebarOpen" class="ml-auto h-4 w-4 text-gray-400" />
                        <ChevronDown v-if="sanctionExpanded && sidebarOpen" class="ml-auto h-4 w-4 text-gray-400" />
                    </button>

                    <!-- Sublinks -->
                    <div v-show="sanctionExpanded" class="ml-8 space-y-1" v-if="sidebarOpen">
                        <!-- Page 1 -->
                        <Link :href="route('sanction.rules.index')" :class="[
                            route().current('sanction.rules.index') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                        Règles de sanction
                        </Link>
                        <!-- Page 2 -->
                        <Link :href="route('sanction.tracking.index')" :class="[
                            route().current('sanction.tracking.index') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                        Suivi des sanctions
                        </Link>

                    </div>

                    <!-- Justificatif Parent -->
                    <button @click="justificatifsExpanded = !justificatifsExpanded" :class="[
                        route().current('Justificatifs.home')
                            ? 'bg-blue-50 text-teal-700'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                        sidebarOpen ? 'justify-start' : 'justify-center',
                        'w-full flex items-center rounded-md px-2 py-2 text-sm font-medium focus:outline-none transition'
                    ]">
                        <FileText :class="[
                            route().current('Justificatifs.home')
                                ? 'text-teal-700'
                                : 'text-gray-500 group-hover:text-gray-500',
                            'mr-3 h-5 w-5 flex-shrink-0'
                        ]" />
                        <span v-if="sidebarOpen">Justificatifs</span>
                        <ChevronRight v-if="!justificatifsExpanded && sidebarOpen" class="ml-auto h-4 w-4 text-gray-400" />
                        <ChevronDown v-if="justificatifsExpanded && sidebarOpen" class="ml-auto h-4 w-4 text-gray-400" />
                    </button>

                    <!-- Sublinks -->
                    <div v-show="justificatifsExpanded" class="ml-8 space-y-1" v-if="sidebarOpen">
                        <!-- Page 1 -->
                        <Link :href="route('Justificatifs.home')" :class="[
                            route().current('Justificatifs.home') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                        Justificatifs list
                        </Link>

                    </div>
                    <!-- Absence Parent -->
                    <button @click="absencesExpanded = !absencesExpanded" :class="[ 
                        route().current('Absences.index')
                            ? 'bg-blue-50 text-teal-700'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                        sidebarOpen ? 'justify-start' : 'justify-center',
                        'w-full flex items-center rounded-md px-2 py-2 text-sm font-medium focus:outline-none transition'
                    ]">
                        <FileText :class="[
                            route().current('Absences.index')
                                ? 'text-teal-700'
                                : 'text-gray-500 group-hover:text-gray-500',
                            'mr-3 h-5 w-5 flex-shrink-0'
                        ]" />
                        <span v-if="sidebarOpen">Absences</span>
                        <ChevronRight v-if="!absencesExpanded && sidebarOpen" class="ml-auto h-4 w-4 text-gray-400" />
                        <ChevronDown v-if="absencesExpanded && sidebarOpen" class="ml-auto h-4 w-4 text-gray-400" />
                    </button>

                    <!-- Sublinks Absences -->
                    <div v-show="absencesExpanded" class="ml-8 space-y-1" v-if="sidebarOpen">
                        <!-- Liste des Absences (Page CRUD) -->
                        <Link :href="route('Absences.index')" :class="[
                            route().current('Absences.index') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                            Liste des Absences
                        </Link>
                    </div>

                </nav>
            </div>


            <!-- Sidebar footer -->
            <div class="border-t border-gray-200 p-4" v-if="sidebarOpen">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                            <User class="h-6 w-6 text-gray-600" />
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-700">{{ $page.props.auth.user.name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $page.props.auth.user.email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile -->
        <div v-if="sidebarOpen && isMobile" @click="toggleSidebar"
            class="fixed inset-0 z-10 bg-gray-600 bg-opacity-50 transition-opacity"></div>

        <!-- Main content -->
        <div :class="[
            sidebarOpen ? 'lg:pl-64' : 'lg:pl-20',
            'flex flex-1 flex-col pt-16 transition-all duration-300 ease-in-out'
        ]">
            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="mx-auto px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1">
                <slot />
            </main>
        </div>
    </div>
</template>