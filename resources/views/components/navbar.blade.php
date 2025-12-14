<!-- <header class="bg-gray-900">
  <nav class="bg-gray-900 border-b border-gray-800 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="flex items-center justify-between">

        <a href="#" class="flex items-center space-x-3 text-white transition hover:text-cyan-400">
          <i class="bi bi-check2-square text-2xl text-cyan-400"></i>
          <span class="text-4xl font-inter font-extrablack tracking-tight">TASK-eLog</span>
        </a>

        @auth
              <div class="hidden lg:flex items-center space-x-6">


                <div class="flex items-center space-x-2 text-gray-300">

                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                    <path fill-rule="evenodd"
                      d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                      clip-rule="evenodd" />
                  </svg> -->


  <!-- <span class="font-inter font-bold text-white">
                        {{ Auth::user()->name }}
                      </span>

                      @if (Auth::user()->isSupervisor())
  <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-700">
                          Supervisor
                        </span>
  @endif -->

  <!-- <span class="font-inter font-bold text-white">
                    {{ Auth::user()->name }}
                  </span>

                  @if (Auth::user()->isSupervisor())
  <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-700">
                      Supervisor
                    </span>
@elseif (Auth::user()->isAdmin())
  <span class="rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-semibold text-purple-700">
                      Admin
                    </span>
@elseif (Auth::user()->isIntern())
  <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">
                      Intern
                    </span>
  @endif
                </div>

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
</header> -->



<!-- <style>
  .navbar-gradient {
    background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
  }
</style>

<header class="navbar-gradient shadow-lg">
  <nav class="border-b border-indigo-600/30 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <div class="flex items-center justify-between">

        <a href="#" class="flex items-center space-x-3 text-white transition hover:text-indigo-100">
          <i class="bi bi-check2-square text-2xl"></i>
          <span class="text-4xl font-inter font-extrablack tracking-tight">TASK-eLog</span>
        </a>

        @auth
              <div class="hidden lg:flex items-center space-x-6">

                <div class="flex items-center space-x-2 text-white">

                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                    <path fill-rule="evenodd"
                      d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z"
                      clip-rule="evenodd" />
                  </svg>

                  <span class="font-inter font-bold text-white">
                    {{ Auth::user()->name }}
                  </span>

                  @if (Auth::user()->isSupervisor())
  <span class="rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-700">
                      Supervisor
                    </span>
@elseif (Auth::user()->isAdmin())
  <span class="rounded-full bg-purple-100 px-2.5 py-0.5 text-xs font-semibold text-purple-700">
                      Admin
                    </span>
@elseif (Auth::user()->isIntern())
  <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-700">
                      Intern
                    </span>
  @endif
                </div>


                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit"
                    class="text-white hover:text-indigo-100 transition flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-white/10">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                  </button>
                </form>
              </div>
        @endauth
      </div>
    </div>
  </nav>
</header> -->

<style>
  .nav-gradient {
    background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
  }
</style>

<nav class="nav-gradient shadow-lg">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">

      <!-- Brand -->
      <a href="{{ route('dashboard') }}"
        class="flex items-center gap-2 sm:gap-3 text-white hover:text-indigo-100 transition shrink-0">
        <i class="bi bi-check2-square text-lg sm:text-xl lg:text-2xl font-black"></i>
        <span
          class="font-montserrat text-xl sm:text-2xl md:text-4xl lg:text-4xl font-black tracking-tight whitespace-nowrap"
          style="font-weight: 900; -webkit-text-stroke: 0.5px white;">
          TASK-eLog
        </span>
      </a>
      @auth
        <!-- Desktop -->
        <div class="hidden lg:flex items-center gap-6">
          <div class="flex items-center gap-2 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
              <path fill-rule="evenodd"
                d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0Z"
                clip-rule="evenodd" />
            </svg>

            <span class="font-semibold">{{ Auth::user()->name }}</span>

            @if (Auth::user()->isSupervisor())
              <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-500 text-white">
                Supervisor
              </span>
            @elseif (Auth::user()->isAdmin())
              <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-purple-300 text-purple-900">
                Admin
              </span>
            @elseif (Auth::user()->isIntern())
              <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-400 text-green-900">
                Intern
              </span>
            @endif
          </div>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
              class="flex items-center gap-1 px-3 py-2 rounded-md text-white hover:text-red-300 hover:bg-white/10 transition">
              <i class="bi bi-box-arrow-right"></i>
              <span>Logout</span>
            </button>
          </form>
        </div>

        <!-- Mobile Toggle -->
        <button id="mobile-menu-btn" class="lg:hidden p-2 rounded-md text-white hover:bg-white/10">
          <svg id="menu-open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg id="menu-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      @endauth
    </div>

    @auth
      <!-- Mobile Menu -->
      <div id="mobile-menu" class="lg:hidden hidden border-t border-white/20 py-4 space-y-4">
        <div class="flex items-center gap-3 text-white">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0Z" />
          </svg>
          <div>
            <p class="font-semibold">{{ Auth::user()->name }}</p>
            <p class="text-xs text-indigo-100">{{ Auth::user()->role }}</p>
          </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button
            class="w-full flex items-center gap-2 px-3 py-2 rounded-md text-white hover:text-red-300 hover:bg-white/10 transition">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
          </button>
        </form>
      </div>
    @endauth
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const openIcon = document.getElementById('menu-open');
    const closeIcon = document.getElementById('menu-close');

    btn?.addEventListener('click', () => {
      menu.classList.toggle('hidden');
      openIcon.classList.toggle('hidden');
      closeIcon.classList.toggle('hidden');
    });
  });
</script>
