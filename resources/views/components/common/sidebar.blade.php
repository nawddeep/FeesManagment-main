<div :class="{ 'dark text-white-dark': $store.app.semidark }">
    <nav x-data="sidebar"
        class="sidebar fixed min-h-screen h-full top-0 bottom-0 w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] z-50 transition-all duration-300">
        <div class="bg-white dark:bg-[#0e1726] h-full">
            <!-- Logo Section -->
            <div class="flex justify-between items-center px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <a href="/" class="main-logo flex items-center">
                    <img class="w-8 ml-[5px]" src="/assets/images/logo.svg" alt="logo" />
                    <span class="text-2xl ml-2 font-semibold dark:text-white-light">Fees Managment</span>
                </a>
                <button
                    class="collapse-icon w-8 h-8 rounded-full flex items-center justify-center hover:bg-gray-200 dark:hover:bg-dark-light/20 transition"
                    @click="$store.app.toggleSidebar()" aria-label="Toggle sidebar">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none">
                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path opacity="0.5" d="M17 19L11 12L17 5" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar Menu -->
            <ul class="perfect-scrollbar font-semibold h-[calc(100vh-80px)] overflow-y-auto overflow-x-hidden p-4"
                x-data="{ activeDropdown: '' }">

                <!-- SCHOOL STUDENTS SECTION -->
                <li class="menu nav-item mb-3">
                    <p class="text-xs uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-2 pl-3">School Section</p>

                    <button type="button"
                        class="nav-link group flex items-center justify-between w-full py-2 px-3 rounded-md hover:bg-gray-100 dark:hover:bg-dark-light/20 transition"
                        :class="{ 'bg-gray-100 dark:bg-dark-light/20': activeDropdown === 'school' }"
                        @click="activeDropdown === 'school' ? activeDropdown = '' : activeDropdown = 'school'">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-primary transition" fill="none"
                                viewBox="0 0 24 24">
                                <path opacity="0.5"
                                    d="M2 12.2C2 9.9 2 8.8 2.5 7.8C3 6.9 4 6.3 5.9 5.1L7.9 3.9C9.9 2.6 10.9 2 12 2C13.1 2 14.1 2.6 16.1 3.9L18.1 5.1C20 6.3 21 6.9 21.5 7.8C22 8.8 22 9.9 22 12.2V13.7C22 17.6 22 19.6 20.8 20.8C19.7 22 17.8 22 14 22H10C6.2 22 4.3 22 3.2 20.8C2 19.6 2 17.6 2 13.7V12.2Z"
                                    fill="currentColor" />
                                <path d="M9 17.25C8.6 17.25 8.25 17.59 8.25 18C8.25 18.41 8.59 18.75 9 18.75H15C15.41 18.75 15.75 18.41 15.75 18C15.75 17.59 15.41 17.25 15 17.25H9Z"
                                    fill="currentColor" />
                            </svg>
                            <span class="ml-3 text-black dark:text-[#a3b3ce]">School Students</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-300"
                            :class="{ 'rotate-90': activeDropdown === 'school' }" viewBox="0 0 24 24" fill="none">
                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <ul x-cloak x-show="activeDropdown === 'school'" x-collapse
                        class="sub-menu text-gray-500 ml-8 mt-1 space-y-1">
                        <li><a href="/sstudent" class="block py-1 hover:text-primary">School Students</a></li>
                        <li><a href="/sclass" class="block py-1 hover:text-primary">Classes</a></li>
                    </ul>
                </li>

                <!-- COMPETITION STUDENTS SECTION -->
                <li class="menu nav-item">
                    <p class="text-xs uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-2 pl-3">Competition Section</p>

                    <button type="button"
                        class="nav-link group flex items-center justify-between w-full py-2 px-3 rounded-md hover:bg-gray-100 dark:hover:bg-dark-light/20 transition"
                        :class="{ 'bg-gray-100 dark:bg-dark-light/20': activeDropdown === 'competition' }"
                        @click="activeDropdown === 'competition' ? activeDropdown = '' : activeDropdown = 'competition'">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-primary transition" fill="none"
                                viewBox="0 0 24 24">
                                <path opacity="0.5"
                                    d="M2 12.2C2 9.9 2 8.8 2.5 7.8C3 6.9 4 6.3 5.9 5.1L7.9 3.9C9.9 2.6 10.9 2 12 2C13.1 2 14.1 2.6 16.1 3.9L18.1 5.1C20 6.3 21 6.9 21.5 7.8C22 8.8 22 9.9 22 12.2V13.7C22 17.6 22 19.6 20.8 20.8C19.7 22 17.8 22 14 22H10C6.2 22 4.3 22 3.2 20.8C2 19.6 2 17.6 2 13.7V12.2Z"
                                    fill="currentColor" />
                                <path d="M9 17.25C8.6 17.25 8.25 17.59 8.25 18C8.25 18.41 8.59 18.75 9 18.75H15C15.41 18.75 15.75 18.41 15.75 18C15.75 17.59 15.41 17.25 15 17.25H9Z"
                                    fill="currentColor" />
                            </svg>
                            <span class="ml-3 text-black dark:text-[#a3b3ce]">Competition Students</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform duration-300"
                            :class="{ 'rotate-90': activeDropdown === 'competition' }" viewBox="0 0 24 24" fill="none">
                            <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <ul x-cloak x-show="activeDropdown === 'competition'" x-collapse
                        class="sub-menu text-gray-500 ml-8 mt-1 space-y-1">
                        <li><a href="/cstudent" class="block py-1 hover:text-primary">Competition Students</a></li>
                        <li><a href="/ssubject" class="block py-1 hover:text-primary">Competition Subjects</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>

<script>
document.addEventListener("alpine:init", () => {
    Alpine.data("sidebar", () => ({
        init() {
            const current = document.querySelector('.sidebar ul a[href="' + window.location.pathname + '"]');
            if (current) {
                current.classList.add('text-primary', 'font-bold');
                const submenu = current.closest('ul.sub-menu');
                if (submenu) {
                    const parentBtn = submenu.closest('li.menu').querySelector('.nav-link');
                    if (parentBtn) setTimeout(() => parentBtn.click(), 100);
                }
            }
        },
    }));
});
</script>
