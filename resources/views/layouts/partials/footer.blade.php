{{-- resources/views/partials/footer.blade.php --}}
<footer class="bg-white border-t border-[#e2e8f0] pt-14 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8 pb-12 border-b border-[#e2e8f0]">

            {{-- Brand --}}
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center gap-2.5">
                    <div class="flex flex-col">
                        <a href="/" class="flex items-center shrink-0">
                            <img src="/assets/img/eventverse-color.png" alt="Eventverse" class="h-9 w-auto">
                        </a>
                    </div>
                </div>
                <p class="text-sm text-[#64748b] max-w-sm leading-relaxed">
                    Platform event management & ticketing sistem terintegrasi untuk pengelolaan event yang profesional, efisien, dan terstruktur dalam satu platform.
                    <a href="/about" class="text-[#2282ff] hover:text-[#1b6cd6] transition-colors">Learn more →</a>
                </p>
                <p class="text-sm text-[#64748b] max-w-sm leading-relaxed">
                    Jl. Mijen permai, mijen permai/BSB city, Kota Semarang, Pos 50219 Indonesia
                </p>
                <p class="text-sm text-[#64748b] max-w-sm leading-relaxed">
                    support@eventverse.id
                </p>
            </div>

            {{-- Company --}}
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-[#0f172a] uppercase tracking-wider">Company</h4>
                <ul class="space-y-2 text-sm text-[#64748b]">
                    <li><a href="/about-us" class="hover:text-[#2282ff] transition-colors">About</a></li>
                    <li><a href="/contact-us" class="hover:text-[#2282ff] transition-colors">Contact</a></li>
                </ul>

                <div class="flex items-center gap-2 mt-3">
                    <a href="https://instagram.com/eventverse_id" target="_blank" rel="noopener noreferrer" class="text-[#64748b] hover:text-[#2282ff] transition-colors">
                        <i class="ti ti-brand-instagram text-xl"></i>
                    </a>
                    <a href="https://instagram.com/info.lomba.beasiswa" target="_blank" rel="noopener noreferrer" class="text-[#64748b] hover:text-[#2282ff] transition-colors">
                        <i class="ti ti-brand-instagram text-xl"></i>
                    </a>
                    <a href="https://wa.me/6282133553002" target="_blank" rel="noopener noreferrer" class="text-[#64748b] hover:text-[#2282ff] transition-colors">
                        <i class="ti ti-brand-whatsapp text-xl"></i>
                    </a>
                </div>
            </div>

            {{-- Explore --}}
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-[#0f172a] uppercase tracking-wider">Explore</h4>
                <ul class="space-y-2 text-sm text-[#64748b]">
                    <li><a href="#events" class="hover:text-[#2282ff] transition-colors">Events</a></li>
                    <li><a href="#categories" class="hover:text-[#2282ff] transition-colors">Event Studio</a></li>
                    <li><a href="#popular" class="hover:text-[#2282ff] transition-colors">Partnership</a></li>
                    <li><a href="#popular" class="hover:text-[#2282ff] transition-colors">Articles</a></li>
                    <li><a href="#popular" class="hover:text-[#2282ff] transition-colors">Check registration</a></li>
                </ul>
            </div>

            {{-- Information --}}
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-[#0f172a] uppercase tracking-wider">INFORMATION</h4>
                <ul class="space-y-2 text-sm text-[#64748b]">
                    <li><a href="/faq" class="hover:text-[#2282ff] transition-colors">Faq</a></li>
                    <li><a href="/pricing" class="hover:text-[#2282ff] transition-colors">Pricing</a></li>
                    <li><a href="/pricing" class="hover:text-[#2282ff] transition-colors">Terms and Conditions</a></li>
                    <li><a href="/pricing" class="hover:text-[#2282ff] transition-colors">Privacy Policy</a></li>
                    <li><a href="/pricing" class="hover:text-[#2282ff] transition-colors">Guidelines</a></li>
                </ul>
            </div>

        </div>

        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#64748b]">
            <p>© 2026 Eventverse. All rights reserved.</p>
            <div>Indonesia (ID)</div>
        </div>
    </div>
</footer>