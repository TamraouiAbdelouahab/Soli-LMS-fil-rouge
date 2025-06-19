<template>
    <div class="min-h-screen bg-gradient-to-br from-white to-blue-50 text-gray-800 flex flex-col">
        <!-- Navbar -->
        <header class="flex items-center justify-between px-6 py-4 shadow-md bg-white">
            <h1 class="text-xl font-bold text-teal-600">Soli LMS</h1>
            <nav class="flex items-center gap-4">
                <Link href="/" class="text-gray-600 hover:text-teal-600 transition">Accueil</Link>
                <template v-if="!$page.props.auth.user">
                    <Link :href="route('login')" class="text-gray-600 hover:text-teal-600 transition">Connexion</Link>
                </template>
                <template v-else-if="!$page.props.auth.user.roles.includes('apprenant')">
                    <Link :href="route('sanction.dashboard')" class="text-gray-600 hover:text-teal-600 transition">Tableau de
                    bord</Link>
                </template>
            </nav>
        </header>

        <!-- Hero Section -->
        <main class="flex-1 flex flex-col justify-center items-center text-center py-9 px-4">
            <h2 class="text-4xl font-extrabold mb-4 text-teal-700">Bienvenue sur Soli LMS</h2>
            <p class="text-lg text-gray-600 max-w-xl">
                Une plateforme complète pour la gestion de l'apprentissage. Modules, compétences, absences, sanctions…
                tout est
                intégré pour simplifier votre travail.
            </p>

            <div class="mt-6 flex gap-4">
                <Link v-if="!$page.props.auth.user" :href="route('login')"
                    class="px-6 py-2 bg-teal-600 text-white rounded-lg shadow hover:bg-teal-700 transition">
                Commencer
                </Link>

                <Link v-else-if="$page.props.auth.user.roles.includes('apprenant')"
                    :href="route('learner.sanction.index')"
                    class="px-6 py-2 bg-teal-600 text-white rounded-lg shadow hover:bg-teal-700 transition">
                Mon Espace
                </Link>

                <Link v-else :href="route('sanction.dashboard')"
                    class="px-6 py-2 bg-teal-600 text-white rounded-lg shadow hover:bg-teal-700 transition">
                Aller au Tableau de bord
                </Link>
            </div>
        </main>

        <!-- Features Section -->
        <section id="features" class="bg-white py-12 px-6">
            <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <div class="bg-blue-50 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-teal-600 mb-2">Gestion des Sanctions</h3>
                    <p class="text-sm text-gray-600">
                        Définissez et appliquez des sanctions automatiquement selon les règles d'absence établies par
                        les
                        responsables.
                    </p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-teal-600 mb-2">Suivi des Absences</h3>
                    <p class="text-sm text-gray-600">
                        Surveillez les absences des apprenants en temps réel avec des statistiques précises et
                        actualisées.
                    </p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-teal-600 mb-2">Gestion des Justifications</h3>
                    <p class="text-sm text-gray-600">
                        Recevez et traitez les justificatifs d'absence via une interface claire et adaptée aux
                        responsables.
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="text-center py-6 text-gray-500 text-sm">
            © 2025 Soli LMS. Tous droits réservés.
        </footer>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
