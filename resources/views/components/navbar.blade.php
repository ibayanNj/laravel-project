<header class="bg-gray-900">
    <nav class="bg-gray-900 border-b border-gray-800 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between">
                <!-- Brand -->
                <a href="#" class="flex items-center space-x-3 text-white transition hover:text-cyan-400">
                    <i class="bi bi-check2-square text-2xl text-cyan-400"></i>
                    <span class="text-2xl font-inter font-extrablack tracking-tight">TASK-eLog</span>
                </a>

                @auth
                    <div class="hidden lg:flex items-center space-x-6">

                        <!-- User Info -->
                        <div class="flex items-center space-x-2 text-gray-300">
                            <i class="bi bi-person-circle text-xl"></i>
                            <span class="text-white font-inter font-bold">{{ Auth::user()->name }}</span>

                            @if (Auth::user()->isSupervisor())

                            @endif
                        </div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-gray-300 hover:text-white transition flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-800">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>
</header>



