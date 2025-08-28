<nav class="bg-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-8">
                <!-- Brand -->
                <a href="#" class="text-xl font-bold text-gray-800">Navbar</a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('genre.create') }}" class="text-gray-800 hover:text-blue-600 px-3 py-2">Home</a>
                    <a href="{{ route('genre.create') }}" class="block text-gray-800 hover:text-blue-600 px-3 py-2">Thể loại </a>
                    <a href="{{ route('category.create') }}" class="block text-gray-600 hover:text-blue-600 px-3 py-2">Danh mục phim</a>
                    <a href="{{ route('country.create') }}" class="block text-gray-600 hover:text-blue-600 px-3 py-2">Quốc gia</a>
                    <a href="{{ route('movie.index') }}" class="block text-gray-600 hover:text-blue-600 px-3 py-2">Phim</a>
                    <a href="{{ route('episode.create') }}" class="block text-gray-600 hover:text-blue-600 px-3 py-2">Tập phim</a>
                    
                    <!-- Dropdown -->
                    <!-- <div class="relative group">
                        <button class="text-gray-600 hover:text-blue-600 px-3 py-2 flex items-center">
                            Dropdown
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Action</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Another action</a>
                            <hr class="my-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Something else here</a>
                        </div>
                    </div> -->
                    
                    <!-- <a href="#" class="text-gray-400 px-3 py-2 cursor-not-allowed">Disabled</a> -->
                </div>
            </div>
            
            <!-- Search Form -->
            <div class="hidden md:flex items-center space-x-2">
                <input type="search" placeholder="Search" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-transparent border border-green-500 text-green-500 rounded-md hover:bg-green-500 hover:text-white transition-colors">
                    Search
                </button>
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button class="text-gray-800 hover:text-blue-600 focus:outline-none" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <a href="#" class="block text-gray-800 hover:text-blue-600 px-3 py-2">Thể loại </a>
            <a href="#" class="block text-gray-600 hover:text-blue-600 px-3 py-2">Danh mục phim</a>
            <a href="#" class="block text-gray-600 hover:text-blue-600 px-3 py-2">Quốc gia</a>
            <a href="#" class="block text-gray-600 hover:text-blue-600 px-3 py-2">Phim</a>
            <a href="#" class="block text-gray-600 hover:text-blue-600 px-3 py-2">Tập phim</a>

            <div class="mt-4 flex items-center space-x-2">
                <input type="search" placeholder="Search" class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="px-4 py-2 bg-transparent border border-green-500 text-green-500 rounded-md hover:bg-green-500 hover:text-white transition-colors">
                    Search
                </button>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}
</script>