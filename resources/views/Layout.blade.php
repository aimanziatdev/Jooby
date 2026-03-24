<!DOCTYPE html>
<html lang="en"
  x-data="jobbyApp()"
  x-init="init(); $watch('darkMode', v => localStorage.setItem('darkMode',''+v))"
  :class="darkMode ? 'dark' : ''"
>
<head>
  <meta charset="UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="images/logo.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
  <script>
    function jobbyApp() {
      const now = () => new Date().toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'});
      return {
        darkMode: localStorage.getItem('darkMode') === 'true',
        chatOpen: false,
        sidebarOpen: false,
        notifCount: 0,
        chatMessages: JSON.parse(localStorage.getItem('jobby_chat') || 'null') || [{from:'bot', text:'Hi! I am Jobby Assistant. How can I help you today? 😊', time: now()}],
        userInput: '',
        isTyping: false,
        updateNotifications() {
          @auth
            fetch('/api/notifications-count')
              .then(r => r.json())
              .then(d => this.notifCount = d.count)
              .catch(() => {});
          @endauth
        },
        init() {
          this.updateNotifications();
          setInterval(() => this.updateNotifications(), 5000);
        },
        sendChat() {
          const q = this.userInput.trim();
          if (!q) return;
          this.chatMessages.push({from:'user', text:q, time: now()});
          this.userInput = '';
          localStorage.setItem('jobby_chat', JSON.stringify(this.chatMessages));
          const lower = q.toLowerCase();

          const faq = [
            {keys:['post','create','add','new','listing','job','poster','announce','post job','create listing'],
              en:'To post a job: log in as a company, click Post New Job in the sidebar, fill in the title, description, and salary range, then submit.'},
            {keys:['apply','application','apply now','submit application','apply for job'],
              en:'To apply for a job: open a job listing and click Apply Now. Your profile info will be sent to the company.'},
            {keys:['hobby','skill','skill listing','hobby listing','what is hobby'],
              en:'A Hobby or Skill listing is posted by an individual to showcase what they can do. Companies can send offers directly to them.'},
            {keys:['offer','send offer','give offer','submit offer','make offer'],
              en:'To send an offer: open a person profile or hobby listing, click Give an Offer, fill in the subject, message, and optional salary, then send.'},
            {keys:['contact','email','phone','telephone','reach out','message'],
              en:'Contact info is visible only after an offer is accepted. Once accepted you will see Email and Phone buttons.'},
            {keys:['salary','price','pay','wage','cost','payment','how much'],
              en:'Salary is shown as a range (min – max MAD/month). It is optional and indicative. Set it when posting or sending an offer.'},
            {keys:['dark','mode','theme','light','dark mode','toggle theme'],
              en:'Click the moon/sun icon in the navbar to toggle dark mode. Your preference is saved automatically.'},
            {keys:['profile','edit profile','update profile','my profile','change profile'],
              en:'Go to your profile via the Profile link in the navbar, then click Edit Profile to update your info.'},
            {keys:['project','add project','portfolio','my projects','portfolio item'],
              en:'On your profile edit page scroll down to the Projects section and click Add Project.'},
            {keys:['register','sign up','create account','join','get started','sign up'],
              en:'Click Get Started in the top-right corner. Choose Company or Individual, fill in your details, and submit.'},
            {keys:['login','sign in','log in','enter password','authenticate'],
              en:'Click Login in the navbar and enter your email and password.'},
            {keys:['logout','sign out','log out','exit account'],
              en:'Click the logout icon (arrow) in the top-right navbar to sign out.'},
            {keys:['notification','bell','badge','alert','notifications'],
              en:'The bell icon shows pending notifications: unread offers for individuals, and offer responses for companies.'},
            {keys:['manage','my listings','my jobs','dashboard','manage listings'],
              en:'Open the grid icon in the navbar or go to My Listings in the sidebar to manage your listings.'},
            {keys:['who','for who','everyone','anyone','designer','developer','photographer','freelancer','student'],
              en:'Jobby is for everyone! Designers, developers, photographers, freelancers, students — anyone with a skill can post a hobby listing. Companies can post jobs and hire talent from any field.'},
            {keys:['delete','remove','delete listing','remove listing'],
              en:'In Manage Listings, click Delete on any listing. This action is permanent.'},
            {keys:['accept','decline','reject','respond to offer','accept offer'],
              en:'In My Offers (individuals), click Accept or Decline on an offer. The company will be notified.'},
            {keys:['filter','search','browse','find','search job','search skill'],
              en:'Use the search bar to search by title or skill. Use All / Jobs / Hobbies tabs to filter.'},
            {keys:['delete account','remove account','close account','deactivate'],
              en:'To delete your account, go to your Profile, click Edit Profile, scroll down, and look for the Delete Account option. Warning: this cannot be undone.'},
            {keys:['password','change password','reset password','forgot password','update password'],
              en:'To change your password, go to your Profile, click Edit Profile, and update your password in the security section.'},
            {keys:['free','fees','cost','price','pay','charge','subscription'],
              en:'Jobby is completely free! There are no fees for posting jobs, applying, or sending offers. You can use all features at no cost.'},
            {keys:['report','flag','inappropriate','spam','abuse','report listing'],
              en:'To report a listing or user for inappropriate content or spam, click the Flag or Report button on the listing page. Our team will review it.'},
            {keys:['company account','become company','switch to company','employer account'],
              en:'To become a company, register as a Company during sign-up, or contact support to upgrade your existing individual account.'},
            {keys:['applicants','who applied','candidates','applied users','see applicants','applications'],
              en:'To view applicants, log in as a company and go to My Applications or Manage Listings. Click on a job to see all who applied.'},
            {keys:['update email','change email','new email','email address'],
              en:'To update your email, go to your Profile, click Edit Profile, and change your email address in the account section.'},
            {keys:['share','link','copy link','send listing','share job','share profile'],
              en:'To share a listing or profile, click the Share button on the listing page to copy the link, then share it on social media or via email.'},
            {keys:['what is jobby','about jobby','jobby platform','how does jobby work'],
              en:'Jobby is a platform that connects companies with talent. Companies post jobs and individuals showcase their skills. Both can send offers directly to each other.'},
            {keys:['language','english','supported language','site language','other languages'],
              en:'Jobby is available in English. All features and support are provided in English.'},
          ];

          let best = null, bestScore = 0;
          for (const item of faq) {
            const score = item.keys.filter(k => lower.includes(k)).length;
            if (score > bestScore) { bestScore = score; best = item; }
          }
          if (bestScore === 0) {
            const words = lower.split(/\s+/);
            for (const item of faq) {
              const score = words.filter(w => w.length >= 4 && item.keys.some(k => k.includes(w) || w.includes(k))).length;
              if (score > bestScore) { bestScore = score; best = item; }
            }
          }
          const matched = bestScore > 0 ? best : null;

          const reply = matched ? matched.en : 'I\'m not sure about that. Try asking about posting a job, applying, sending offers, profiles, salary, accounts, or password.';

          this.isTyping = true;
          setTimeout(() => {
            this.chatMessages.push({from:'bot', text:reply, time: now()});
            this.isTyping = false;
            localStorage.setItem('jobby_chat', JSON.stringify(this.chatMessages));
            this.$nextTick(() => { const el = document.getElementById('chat-msgs'); if(el) el.scrollTop = el.scrollHeight; });
          }, 400);
        },
        clearChat() {
          this.chatMessages = [{from:'bot', text:'Hi! I am Jobby Assistant. How can I help you today? 😊', time: now()}];
          localStorage.removeItem('jobby_chat');
        },
        askBot(q) { this.userInput = q; this.chatOpen = true; this.sendChat(); }
      }
    }
  </script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: { brand: { red:'#DC2626', darkred:'#991B1B', black:'#0F0F0F', green:'#16A34A' } },
          fontFamily: { sans: ['Inter','sans-serif'] }
        }
      }
    }
  </script>
  <style>
    body { font-family:'Inter',sans-serif; }
    .nav-blur { backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); }
    .gradient-text { background:linear-gradient(135deg,#DC2626,#991B1B); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .card-hover { transition:all 0.25s ease; }
    .card-hover:hover { transform:translateY(-3px); box-shadow:0 20px 40px rgba(0,0,0,0.12); }
    .btn-primary { background:linear-gradient(135deg,#DC2626,#B91C1C); transition:all 0.2s ease; display:inline-flex; align-items:center; justify-content:center; }
    .btn-primary:hover { background:linear-gradient(135deg,#B91C1C,#991B1B); transform:translateY(-1px); box-shadow:0 8px 20px rgba(220,38,38,0.35); }
    .btn-green { background:linear-gradient(135deg,#16A34A,#15803D); transition:all 0.2s ease; display:inline-flex; align-items:center; justify-content:center; }
    .btn-green:hover { background:linear-gradient(135deg,#15803D,#166534); transform:translateY(-1px); box-shadow:0 8px 20px rgba(22,163,74,0.35); }
    input:focus, textarea:focus, select:focus { outline:none; border-color:#DC2626; box-shadow:0 0 0 3px rgba(220,38,38,0.1); }
    .chat-bot { background:#1F2937; color:white; border-radius:0 16px 16px 16px; }
    .chat-user { background:#DC2626; color:white; border-radius:16px 0 16px 16px; }
  </style>
  <title>JOBBY | Find Your Dream Job or Hobby in 2026</title>
</head>

<body class="bg-gray-50 dark:bg-gray-950 min-h-screen transition-colors duration-300" style="padding-bottom:80px;">

<!-- Navbar -->
<nav class="sticky top-0 z-50 bg-brand-black/95 nav-blur border-b border-gray-800">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <a href="/" class="flex items-center group">
        <div class="bg-white rounded-lg px-2 py-1 group-hover:scale-105 transition-transform flex items-center">
          <img src="/Jobby_logo.png" alt="Jobby" class="h-7 w-auto">
          <span class="ml-2 text-brand-red font-bold tracking-wider text-xl select-none">JOBBY</span>
        </div>
      </a>
      <ul class="flex items-center space-x-1">
        <li>
          <button @click="darkMode=!darkMode" class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-white/10 transition-all">
            <i class="fa-solid" :class="darkMode ? 'fa-sun text-yellow-400' : 'fa-moon'"></i>
          </button>
        </li>
        @auth
        <li class="hidden md:flex items-center space-x-1.5 px-3 py-1.5 rounded-lg bg-white/5">
          <i class="fa-solid fa-circle-user text-brand-green text-sm"></i>
          <span class="text-gray-300 text-sm font-medium">{{auth()->user()->name}}</span>
          @if(auth()->user()->isCompany())
            <span class="bg-brand-red text-white text-xs px-1.5 py-0.5 rounded font-bold">CO</span>
          @else
            <span class="bg-brand-green text-white text-xs px-1.5 py-0.5 rounded font-bold">ME</span>
          @endif
        </li>
        <li>
          @if(auth()->user()->isPerson())
            <a href="/my-offers" class="relative flex items-center text-gray-300 hover:text-white text-sm font-medium px-3 py-2 rounded-lg hover:bg-white/10 transition-all">
              <i class="fa-solid fa-bell"></i>
              <span x-show="notifCount > 0" class="absolute top-1 right-1 w-4 h-4 bg-brand-red rounded-full text-white text-xs font-black flex items-center justify-center leading-none" x-text="notifCount"></span>
            </a>
          @else
            <a href="/sent-offers" class="relative flex items-center text-gray-300 hover:text-white text-sm font-medium px-3 py-2 rounded-lg hover:bg-white/10 transition-all">
              <i class="fa-solid fa-bell"></i>
              <span x-show="notifCount > 0" class="absolute top-1 right-1 w-4 h-4 bg-brand-green rounded-full text-white text-xs font-black flex items-center justify-center leading-none" x-text="notifCount"></span>
            </a>
          @endif
        </li>
        <li>
          <a href="/listings/manage" class="relative flex items-center text-gray-300 hover:text-white text-sm font-medium px-3 py-2 rounded-lg hover:bg-white/10 transition-all">
            <i class="fa-solid fa-grid-2"></i>
          </a>
        </li>
        <li>
          <a href="/profile/{{auth()->id()}}" class="flex items-center text-gray-300 hover:text-white text-sm font-medium px-3 py-2 rounded-lg hover:bg-white/10 transition-all">
            <i class="fa-solid fa-user"></i><span class="hidden sm:inline ml-1">Profile</span>
          </a>
        </li>
        <li>
          <form class="inline" method="POST" action="/logout">@csrf
            <button type="submit" class="flex items-center text-gray-400 hover:text-white text-sm px-3 py-2 rounded-lg hover:bg-white/10 transition-all">
              <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </button>
          </form>
        </li>
        @else
        <li><a href="/login" class="text-gray-300 hover:text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-white/10 transition-all">Login</a></li>
        <li><a href="/register" class="btn-primary text-white text-sm font-semibold px-4 py-2 rounded-lg">Get Started</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<main>@yield('content')</main>

<!-- Footer -->
<footer class="fixed bottom-0 left-0 w-full bg-brand-black border-t border-gray-800 z-40">
  <div class="max-w-7xl mx-auto px-4 h-14 flex items-center justify-between">
    <div class="flex items-center space-x-2">
      <div class="bg-white rounded px-1.5 py-0.5">
        <img src="/Jobby_logo.png" alt="Jobby" class="h-5 w-auto">
      </div>
      <p class="text-gray-400 text-xs">© 2026 <span class="text-white font-semibold">JOBBY</span>. All rights reserved.</p>
    </div>
    <div class="flex items-center space-x-3">
      <a href="/" class="text-gray-500 hover:text-gray-300 text-xs transition-colors">Browse Jobs</a>
      @guest<a href="/listings/create" class="btn-primary text-white text-xs font-semibold px-3 py-1.5 rounded-md"><i class="fa-solid fa-plus mr-1"></i>Post a Job</a>@endguest
    </div>
  </div>
</footer>

<!-- Chatbot -->
<div class="fixed bottom-16 right-4 z-50">
  <div x-show="chatOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-end="opacity-0 scale-95"
    class="mb-3 w-80 bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col max-h-[600px]">
    <div class="bg-brand-black px-4 py-3 flex items-center justify-between flex-shrink-0">
      <div class="flex items-center space-x-2">
        <div class="w-8 h-8 bg-brand-red rounded-full flex items-center justify-center"><i class="fa-solid fa-robot text-white text-sm"></i></div>
        <div><p class="text-white font-bold text-sm">Jobby Assistant</p><p class="text-green-400 text-xs"><span class="inline-block w-1.5 h-1.5 bg-green-400 rounded-full mr-1 animate-pulse"></span>Online</p></div>
      </div>
      <div class="flex items-center gap-2">
        <button @click="clearChat()" class="text-gray-400 hover:text-white text-sm" title="Clear chat"><i class="fa-solid fa-trash"></i></button>
        <button @click="chatOpen=false" class="text-gray-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
      </div>
    </div>
    <div id="chat-msgs" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50 dark:bg-gray-950 min-h-0">
      <template x-for="(msg,i) in chatMessages" :key="i">
        <div :class="msg.from==='bot' ? 'flex justify-start' : 'flex justify-end'">
          <div class="max-w-xs">
            <div :class="msg.from==='bot' ? 'chat-bot' : 'chat-user'" class="px-3 py-2 text-sm" x-text="msg.text"></div>
            <p class="text-xs text-gray-400 mt-1" :class="msg.from==='bot' ? 'text-left' : 'text-right'" x-text="msg.time"></p>
          </div>
        </div>
      </template>
      <div x-show="isTyping" class="flex justify-start">
        <div class="chat-bot px-3 py-2">
          <span class="inline-flex gap-1">
            <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
            <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
            <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
          </span>
        </div>
      </div>
    </div>
    <div class="px-3 py-2 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 flex-shrink-0">
      <p class="text-xs text-gray-400 mb-2 font-medium">Quick questions:</p>
      <div class="overflow-x-auto flex gap-1">
        <button @click="askBot('How do I post a job?')" class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full hover:bg-brand-red hover:text-white transition-all whitespace-nowrap flex-shrink-0">Post job</button>
        <button @click="askBot('How do I apply for a job?')" class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full hover:bg-brand-red hover:text-white transition-all whitespace-nowrap flex-shrink-0">Apply</button>
        <button @click="askBot('What is a hobby listing?')" class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full hover:bg-brand-red hover:text-white transition-all whitespace-nowrap flex-shrink-0">Hobby</button>
        <button @click="askBot('How to send an offer?')" class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full hover:bg-brand-red hover:text-white transition-all whitespace-nowrap flex-shrink-0">Offer</button>
        <button @click="askBot('How to contact someone?')" class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full hover:bg-brand-red hover:text-white transition-all whitespace-nowrap flex-shrink-0">Contact</button>
        <button @click="askBot('How does salary work?')" class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full hover:bg-brand-red hover:text-white transition-all whitespace-nowrap flex-shrink-0">Salary</button>
        <button @click="askBot('Is Jobby free?')" class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full hover:bg-brand-red hover:text-white transition-all whitespace-nowrap flex-shrink-0">Free?</button>
        <button @click="askBot('How to delete my account?')" class="text-xs bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full hover:bg-brand-red hover:text-white transition-all whitespace-nowrap flex-shrink-0">Delete account</button>
      </div>
    </div>
    <div class="p-3 border-t border-gray-100 dark:border-gray-800 flex gap-2 flex-shrink-0">
      <input x-model="userInput" @keydown.enter="sendChat()" type="text" placeholder="Ask anything..."
        class="flex-1 text-sm border border-gray-200 dark:border-gray-700 rounded-xl px-3 py-2 bg-white dark:bg-gray-800 dark:text-white">
      <button @click="sendChat()" class="btn-primary text-white px-3 py-2 rounded-xl text-sm">
        <i class="fa-solid fa-paper-plane"></i>
      </button>
    </div>
  </div>
  <button @click="chatOpen=!chatOpen" class="btn-primary w-12 h-12 rounded-full text-white shadow-lg ml-auto relative block">
    <i class="fa-solid" :class="chatOpen ? 'fa-xmark' : 'fa-robot'"></i>
    <span x-show="!chatOpen" class="absolute -top-1 -right-1 w-4 h-4 bg-brand-green rounded-full border-2 border-white animate-pulse"></span>
  </button>
</div>

<x-flash-message />
</body>
</html>
