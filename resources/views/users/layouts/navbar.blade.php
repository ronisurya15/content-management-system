<!-- Navbar -->
<header class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
            <span class="text-xl font-bold text-blue-900">
                <a href="/"> MINI CMS</a>
            </span>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-6">
            <nav class="flex space-x-6">
                <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-900 font-medium">Blog</a>
            </nav>
        </div>

        <!-- Mobile Right Section -->
        <div class="flex items-center space-x-3 md:hidden">
            <!-- Hamburger Icon -->
            <button id="hamburger" class="focus:outline-none" aria-label="Toggle navigation menu">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" role="img" aria-hidden="true">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-4 bg-white border-t">
        <nav class="flex flex-col space-y-3 py-4">
            <a href="{{ route('blog.index') }}" class="text-gray-700 hover:text-blue-900 font-medium">Blog</a>
        </nav>
    </div>
</header>