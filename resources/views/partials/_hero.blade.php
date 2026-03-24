<style>
  @keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
  }
  @keyframes pulse-glow {
    0%, 100% { opacity: 0.3; }
    50% { opacity: 0.6; }
  }
  @keyframes slide-in-left {
    from { opacity: 0; transform: translateX(-50px); }
    to { opacity: 1; transform: translateX(0); }
  }
  @keyframes slide-in-right {
    from { opacity: 0; transform: translateX(50px); }
    to { opacity: 1; transform: translateX(0); }
  }
  @keyframes fade-in-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .float-animation { animation: float 3s ease-in-out infinite; }
  .pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
  .slide-left { animation: slide-in-left 0.8s ease-out; }
  .slide-right { animation: slide-in-right 0.8s ease-out; }
  .fade-up { animation: fade-in-up 0.8s ease-out; }
  .icon-float { animation: float 4s ease-in-out infinite; }
  .icon-float:nth-child(2) { animation-delay: 0.5s; }
  .icon-float:nth-child(3) { animation-delay: 1s; }
</style>

<section class="relative bg-brand-black overflow-hidden">
  <!-- Background Pattern -->
  <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;"></div>

  <!-- Animated Glows -->
  <div class="absolute top-0 right-0 w-96 h-96 bg-brand-red opacity-10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pulse-glow"></div>
  <div class="absolute bottom-0 left-0 w-80 h-80 bg-brand-green opacity-5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3 pulse-glow" style="animation-delay: 1s;"></div>

  <!-- Animated Icons Grid -->
  <div class="absolute inset-0 opacity-10 overflow-hidden">
    <div class="absolute top-20 left-10 text-4xl icon-float">💼</div>
    <div class="absolute top-32 right-16 text-4xl icon-float">🚀</div>
    <div class="absolute bottom-24 left-1/4 text-4xl icon-float">⭐</div>
    <div class="absolute bottom-32 right-1/4 text-4xl icon-float">🎯</div>
    <div class="absolute top-1/2 right-10 text-4xl icon-float">💡</div>
    <div class="absolute top-40 left-1/3 text-4xl icon-float">✨</div>
  </div>

  <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <!-- Left Content -->
      <div class="text-center lg:text-left">
        <!-- Badge -->
        <div class="inline-flex items-center space-x-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 mb-8 slide-left">
          <div class="w-2 h-2 bg-brand-green rounded-full animate-pulse"></div>
          <span class="text-white text-sm font-medium">1,200+ Active Job Listings</span>
        </div>

        <!-- Headline -->
        <h1 class="text-5xl md:text-6xl font-black text-white mb-6 leading-tight slide-left" style="animation-delay: 0.1s;">
          Find Your<br>
          <span class="gradient-text">Dream Career</span><br>
          <span class="text-3xl md:text-4xl font-bold text-gray-300">in 2026</span>
        </h1>

        <p class="text-gray-400 text-lg md:text-xl max-w-2xl mb-10 leading-relaxed fade-up" style="animation-delay: 0.2s;">
          Connect with top companies worldwide. Discover opportunities that match your skills and ambitions.
        </p>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center lg:items-start gap-4 mb-12 fade-up" style="animation-delay: 0.3s;">
          @guest
          <a href="/register" class="btn-primary text-white font-bold px-8 py-4 rounded-xl text-lg flex items-center space-x-2 hover:scale-105 transition-transform">
            <i class="fa-solid fa-rocket"></i>
            <span>Post a Job Free</span>
          </a>
          @endguest
          <a href="#listings" class="border-2 border-white/20 text-white hover:border-white/40 font-semibold px-8 py-4 rounded-xl text-lg transition-all hover:bg-white/5 flex items-center space-x-2">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span>Browse All Jobs</span>
          </a>
        </div>

        <!-- Stats -->
        <div class="flex flex-col sm:flex-row items-start lg:items-center gap-6 sm:gap-12 fade-up" style="animation-delay: 0.4s;">
          <div>
            <div class="text-3xl font-black text-brand-red">500+</div>
            <div class="text-gray-400 text-sm mt-1">Companies Hiring</div>
          </div>
          <div class="hidden sm:block w-px h-10 bg-gray-700"></div>
          <div>
            <div class="text-3xl font-black text-white">1.2K+</div>
            <div class="text-gray-400 text-sm mt-1">Active Jobs</div>
          </div>
          <div class="hidden sm:block w-px h-10 bg-gray-700"></div>
          <div>
            <div class="text-3xl font-black text-brand-green">98%</div>
            <div class="text-gray-400 text-sm mt-1">Success Rate</div>
          </div>
        </div>
      </div>

      <!-- Right Illustration - 3 Floating Cards -->
      <div class="relative h-72 sm:h-80 md:h-96 lg:h-full flex items-center justify-center slide-right mt-8 lg:mt-0">
        <div class="relative w-full h-full flex items-center justify-center perspective">

          <!-- Card 1: Full Stack Dev (Top Left) -->
          <div class="absolute w-64 sm:w-72 h-44 sm:h-48 bg-gradient-to-br from-blue-500 to-blue-900 rounded-2xl shadow-2xl p-4 sm:p-6 float-animation hover:shadow-3xl transition-shadow text-sm sm:text-base" style="top: -10px; left: -20px; transform: rotate(-8deg);">
            <div class="absolute top-3 right-3 w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
              <i class="fa-solid fa-star text-yellow-300 text-sm"></i>
            </div>
            <div class="flex items-center space-x-3 mb-4">
              <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-code text-white text-lg"></i>
              </div>
              <div>
                <p class="text-white font-bold text-sm">Full Stack Developer</p>
                <p class="text-white/70 text-xs">Job • Remote</p>
              </div>
            </div>
            <p class="text-white/90 text-sm mb-3">Build modern web applications with React & Laravel</p>
            <div class="flex gap-2 mb-4 flex-wrap">
              <span class="bg-white/25 text-white text-xs px-2.5 py-1 rounded-full font-medium">React</span>
              <span class="bg-white/25 text-white text-xs px-2.5 py-1 rounded-full font-medium">Laravel</span>
              <span class="bg-white/25 text-white text-xs px-2.5 py-1 rounded-full font-medium">MySQL</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-white font-bold text-lg">120K-180K د.م.</span>
              <span class="text-white/70 text-xs">/year</span>
            </div>
          </div>

          <!-- Card 2: Designer (Top Right) -->
          <div class="absolute w-64 sm:w-72 h-44 sm:h-48 bg-gradient-to-br from-purple-500 to-purple-900 rounded-2xl shadow-2xl p-4 sm:p-6 float-animation hover:shadow-3xl transition-shadow text-sm sm:text-base" style="top: 10px; right: -30px; transform: rotate(6deg); animation-delay: 0.5s;">
            <div class="absolute top-3 right-3 w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
              <i class="fa-solid fa-star text-yellow-300 text-sm"></i>
            </div>
            <div class="flex items-center space-x-3 mb-4">
              <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-palette text-white text-lg"></i>
              </div>
              <div>
                <p class="text-white font-bold text-sm">Senior UI/UX Designer</p>
                <p class="text-white/70 text-xs">Job • Hybrid</p>
              </div>
            </div>
            <p class="text-white/90 text-sm mb-3">Design beautiful, user-centered digital experiences</p>
            <div class="flex gap-2 mb-4 flex-wrap">
              <span class="bg-white/25 text-white text-xs px-2.5 py-1 rounded-full font-medium">Figma</span>
              <span class="bg-white/25 text-white text-xs px-2.5 py-1 rounded-full font-medium">UI/UX</span>
              <span class="bg-white/25 text-white text-xs px-2.5 py-1 rounded-full font-medium">Design</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-white font-bold text-lg">100K-150K د.م.</span>
              <span class="text-white/70 text-xs">/year</span>
            </div>
          </div>

          <!-- Card 3: Hobby/Skill (Bottom Center) -->
          <div class="absolute w-64 sm:w-72 h-44 sm:h-48 bg-gradient-to-br from-emerald-500 to-emerald-900 rounded-2xl shadow-2xl p-4 sm:p-6 float-animation hover:shadow-3xl transition-shadow text-sm sm:text-base" style="bottom: -20px; animation-delay: 1s;">
            <div class="absolute top-3 right-3 w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
              <i class="fa-solid fa-heart text-red-300 text-sm"></i>
            </div>
            <div class="flex items-center space-x-3 mb-4">
              <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-lightbulb text-white text-lg"></i>
              </div>
              <div>
                <p class="text-white font-bold text-sm">Graphic Design Services</p>
                <p class="text-white/70 text-xs">Hobby/Skill • Freelance</p>
              </div>
            </div>
            <p class="text-white/90 text-sm mb-3">Create stunning graphics and brand identities for projects</p>
            <div class="flex gap-2 mb-4 flex-wrap">
              <span class="bg-white/25 text-white text-xs px-2.5 py-1 rounded-full font-medium">Adobe CC</span>
              <span class="bg-white/25 text-white text-xs px-2.5 py-1 rounded-full font-medium">Branding</span>
              <span class="bg-white/25 text-white text-xs px-2.5 py-1 rounded-full font-medium">Creative</span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-white font-bold text-lg">Negotiate</span>
              <span class="text-white/70 text-xs">Flexible Rate</span>
            </div>
          </div>

          <!-- Center Glow -->
          <div class="absolute w-40 h-40 rounded-full bg-gradient-to-r from-blue-400 via-purple-400 to-emerald-400 opacity-15 blur-3xl animate-pulse"></div>
        </div>
      </div>
    </div>
  </div>
</section>
