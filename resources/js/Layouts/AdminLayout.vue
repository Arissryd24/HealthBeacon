<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';

const showingSidebar = ref(true);

const menuItems = [
    { label: 'Dashboard', href: 'admin.dashboard', icon: '📊' },
    { label: 'Manajemen User', href: 'admin.users.index', icon: '👥' },
    { label: 'Threshold Alert', href: 'admin.thresholds.index', icon: '⚙️' },
    { label: 'Log Aktivitas', href: 'admin.activity-logs.index', icon: '📋' },
];
</script>

<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div
            :class="{ 'w-64': showingSidebar, 'w-0': !showingSidebar }"
            class="transition-all duration-300 bg-gray-900 text-white shadow-lg"
        >
            <!-- Logo -->
            <div class="h-16 flex items-center justify-center border-b border-gray-700">
                <Link :href="route('dashboard')" class="flex items-center">
                    <ApplicationLogo class="block h-8 w-auto fill-current" />
                    <span class="ml-3 font-bold text-lg">HealthBeacon</span>
                </Link>
            </div>

            <!-- Menu -->
            <nav class="mt-8 px-4 space-y-2">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">
                    Admin Panel
                </div>
                <Link
                    v-for="item in menuItems"
                    :key="item.href"
                    :href="route(item.href)"
                    :class="[
                        'flex items-center px-4 py-3 rounded-lg transition-colors',
                        route().current(item.href.replace('.index', '.*'))
                            ? 'bg-indigo-600 text-white'
                            : 'text-gray-300 hover:bg-gray-800'
                    ]"
                >
                    <span class="text-xl mr-3">{{ item.icon }}</span>
                    <span>{{ item.label }}</span>
                </Link>

                <div class="border-t border-gray-700 my-4"></div>

                <!-- Back to User Dashboard -->
                <Link
                    :href="route('dashboard')"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 transition-colors"
                >
                    <span class="text-xl mr-3">←</span>
                    <span>Kembali ke Dashboard</span>
                </Link>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <nav class="bg-white border-b border-gray-200 shadow">
                <div class="px-4 sm:px-6 lg:px-8 flex h-16 justify-between items-center">
                    <!-- Toggle Sidebar -->
                    <button
                        @click="showingSidebar = !showingSidebar"
                        class="p-2 rounded-lg hover:bg-gray-100 text-gray-600"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- User Menu -->
                    <div class="relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                    >
                                        {{ $page.props.auth.user.name }}
                                        <svg
                                            class="-me-0.5 ms-2 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    Profile
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Logout
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white border-b border-gray-200" v-if="$slots.header">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto">
                <slot />
            </main>
        </div>
    </div>
</template>
