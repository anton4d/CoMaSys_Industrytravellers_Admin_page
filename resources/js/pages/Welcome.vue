<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { login } from '@/routes';
</script>

<template>
    <Head title="Industry Traveller — Admin" />

    <div class="min-h-screen bg-[#0D0D0D] text-white flex flex-col" style="font-family: 'Georgia', serif;">

        <!-- Subtle grid texture overlay -->
        <div class="fixed inset-0 pointer-events-none opacity-[0.03]"
            style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 40px 40px;">
        </div>

        <!-- Top bar -->
        <header class="relative z-10 flex items-center justify-between px-10 py-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <!-- Wordmark -->
                <span class="text-xs tracking-[0.3em] uppercase text-white/40 font-sans">Industry Traveller</span>
                <span class="text-white/20">·</span>
                <span class="text-xs tracking-[0.3em] uppercase text-[#C9A84C] font-sans">Admin</span>
            </div>
            <div class="text-xs text-white/20 font-sans tracking-widest uppercase">Backend Portal</div>
        </header>

        <!-- Main content -->
        <main class="relative z-10 flex flex-1 flex-col items-center justify-center px-6 py-20">

            <!-- Decorative lines -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 w-px h-64 bg-gradient-to-b from-transparent via-white/10 to-transparent hidden lg:block"></div>
            <div class="absolute right-0 top-1/2 -translate-y-1/2 w-px h-64 bg-gradient-to-b from-transparent via-white/10 to-transparent hidden lg:block"></div>

            <div class="max-w-2xl w-full text-center">

                <!-- Eyebrow -->
                <p class="text-xs tracking-[0.4em] uppercase text-[#C9A84C] mb-8 font-sans opacity-0 animate-fadein" style="animation-delay: 0.1s; animation-fill-mode: forwards;">
                    Restricted Access
                </p>

                <!-- Main heading -->
                <h1 class="opacity-0 animate-fadein" style="font-size: clamp(2.8rem, 6vw, 5rem); line-height: 1.05; letter-spacing: -0.02em; animation-delay: 0.25s; animation-fill-mode: forwards;">
                    Industry Traveller<br>
                    <span style="color: #C9A84C;">Admin Backend</span>
                </h1>

                <!-- Divider -->
                <div class="flex items-center justify-center gap-4 my-10 opacity-0 animate-fadein" style="animation-delay: 0.4s; animation-fill-mode: forwards;">
                    <div class="h-px w-16 bg-white/20"></div>
                    <div class="w-1 h-1 rounded-full bg-[#C9A84C]"></div>
                    <div class="h-px w-16 bg-white/20"></div>
                </div>

                <!-- Description -->
                <p class="text-white/50 leading-relaxed max-w-lg mx-auto font-sans text-base opacity-0 animate-fadein" style="animation-delay: 0.5s; animation-fill-mode: forwards;">
                    This is the administration backend for the Industry Traveller website and app.
                    Access is limited to authorised administrators only.
                    If you require access, contact an existing administrator.
                </p>

                <!-- CTA -->
                <div class="mt-12 opacity-0 animate-fadein" style="animation-delay: 0.65s; animation-fill-mode: forwards;">
                    <Link
                        :href="login()"
                        class="group inline-flex items-center gap-3 border border-[#C9A84C] px-10 py-4 text-sm tracking-[0.2em] uppercase font-sans text-[#C9A84C] transition-all duration-300 hover:bg-[#C9A84C] hover:text-[#0D0D0D]"
                    >
                        <span>Sign In</span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 16 16">
                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="square"/>
                        </svg>
                    </Link>
                </div>

                <!-- Fine print -->
                <p class="mt-8 text-xs text-white/20 font-sans tracking-wide opacity-0 animate-fadein" style="animation-delay: 0.8s; animation-fill-mode: forwards;">
                    Unauthorised access attempts are logged.
                </p>

            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 flex items-center justify-between px-10 py-5 border-t border-white/10">
            <span class="text-xs text-white/20 font-sans">© {{ new Date().getFullYear() }} Industry Traveller</span>
            <span class="text-xs text-white/20 font-sans">v1.0</span>
        </footer>

    </div>
</template>

<style>
@keyframes fadein {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
.animate-fadein {
    animation: fadein 0.6s ease-out;
}
</style>