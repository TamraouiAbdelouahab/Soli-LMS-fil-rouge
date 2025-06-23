<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, usePage, router } from '@inertiajs/vue3';
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

const page = usePage();
const notifications = page.props.notifications || []

function handleClick(notification) {
    router.post(route('notifications.markAsRead', notification.id), {
        redirect_url: notification.url
    });
}

const dashboardExpanded = ref(false)
const sanctionExpanded = ref(false)
const justificatifsExpanded = ref(false)

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

                        <Link :href="route('home')" class="flex items-center">
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
                    <div class="flex items-center space-x-4">
                        <!-- Notifications Dropdown -->
                        <Dropdown align="right" width="60">
                            <template #trigger>
                                <button
                                    class="relative rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-600 focus:outline-none">
                                    <Bell class="h-6 w-6" />
                                    <span v-if="notifications.length > 0"
                                        class="absolute top-0 right-0 inline-flex h-2 w-2 rounded-full bg-red-600"></span>
                                </button>
                            </template>

                            <template #content>
                                <div class="max-h-60 overflow-y-auto">
                                    <template v-if="notifications.length">
                                        <div v-for="n in notifications" :key="n.id"
                                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer" @click="handleClick(n)">
                                            <div class="block text-sm font-medium text-gray-700">
                                                <div class="font-semibold">{{ n.title }}</div>
                                                <div class="text-xs text-gray-500 truncate">{{ n.message }}</div>
                                                <div class="text-xs text-gray-400 mt-1">{{ n.time }}</div>
                                            </div>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="px-4 py-2 text-gray-500 text-sm">Aucune notification</div>
                                    </template>
                                </div>
                            </template>
                        </Dropdown>

                        <!-- Profile Dropdown -->
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex items-center rounded-full border border-transparent bg-white p-1 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <div class="mr-2 h-8 w-8 overflow-hidden rounded-full bg-gray-200">
                                        <User class="h-full w-full p-1 text-gray-600" />
                                    </div>
                                    <div class="hidden md:block">{{ page.props.auth.user.name }}</div>
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
                <Link :href="route('home')" class="flex items-center" v-show="sidebarOpen">
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
                        <Link
                            v-if="['responsable des apprenants', 'responsable de formation'].some(role => page.props.auth.user?.roles?.includes(role))"
                            :href="route('sanction.dashboard')" :class="[
                                route().current('sanction.dashboard') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                                'block text-sm py-1 transition'
                            ]">
                        Sanctions
                        </Link>

                        <!-- Page 2 -->
                        <Link
                            v-if="['responsable des apprenants', 'responsable de formation'].some(role => page.props.auth.user?.roles?.includes(role))"
                            :href="route('Justificatifs.dashboard')" :class="[
                                route().current('Justificatifs.dashboard') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                                'block text-sm py-1 transition'
                            ]">
                        Justificatifs
                        </Link>

                        <!-- Page 3 -->
                        <Link
                            v-if="['responsable des apprenants', 'responsable de formation'].some(role => page.props.auth.user?.roles?.includes(role))"
                            :href="route('absence.dashboard')" :class="[
                                route().current('absence.dashboard') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                                'block text-sm py-1 transition'
                            ]">
                        Absences
                        </Link>
                    </div>

                    <!-- Sanction Parent -->
                    <button @click="sanctionExpanded = !sanctionExpanded" :class="[
                        route().current('sanction.rules.index') || route().current('sanction.tracking.index') || route().current('learner.sanction.index')
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
                        <Link
                            v-if="['responsable des apprenants', 'responsable de formation'].some(role => page.props.auth.user?.roles?.includes(role))"
                            :href="route('sanction.rules.index')" :class="[
                                route().current('sanction.rules.index') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                                'block text-sm py-1 transition'
                            ]">
                        Règles de sanction
                        </Link>

                        <!-- Page 2 -->
                        <Link
                            v-if="['responsable des apprenants', 'responsable de formation'].some(role => page.props.auth.user?.roles?.includes(role))"
                            :href="route('sanction.tracking.index')" :class="[
                                route().current('sanction.tracking.index') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                                'block text-sm py-1 transition'
                            ]">
                        Suivi des sanctions
                        </Link>

                        <!-- Page 3 -->
                        <Link v-if="page.props.auth.user?.roles?.includes('apprenant')"
                            :href="route('learner.sanction.index')" :class="[
                                route().current('learner.sanction.index') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                                'block text-sm py-1 transition'
                            ]">
                        Mes sanctions
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
                        <ChevronRight v-if="!justificatifsExpanded && sidebarOpen"
                            class="ml-auto h-4 w-4 text-gray-400" />
                        <ChevronDown v-if="justificatifsExpanded && sidebarOpen"
                            class="ml-auto h-4 w-4 text-gray-400" />
                    </button>

                    <!-- Sublinks -->
                    <div v-show="justificatifsExpanded" class="ml-8 space-y-1" v-if="sidebarOpen">
                        <!-- Page 1 -->
                        <Link
                            v-if="['responsable des apprenants', 'responsable de formation'].some(role => page.props.auth.user?.roles?.includes(role))"
                        :href="route('Justificatifs.home')" :class="[
                            route().current('Justificatifs.home') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                        Liste des justificatifs
                        </Link>
                        <Link
                            v-if="['responsable des apprenants', 'responsable de formation'].some(role => page.props.auth.user?.roles?.includes(role))"
                        :href="route('reasons.home')" :class="[
                            route().current('reasons.home') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                        Liste des raisons
                        </Link>
                        <Link
                            v-if="page.props.auth.user?.roles?.includes('apprenant')"
                        :href="route('Justificatifs.apprenant')" :class="[
                            route().current('Justificatifs.apprenant') ? 'text-teal-700' : 'text-gray-600 hover:text-teal-600',
                            'block text-sm py-1 transition'
                        ]">
                        Mes justificatifs
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
