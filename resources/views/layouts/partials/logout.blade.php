{{-- resources/views/partials/logout-modal.blade.php --}}
<div id="logout-modal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">

    <div id="logout-modal-backdrop" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    <div class="relative w-full max-w-sm rounded-2xl bg-white border border-[#e2e8f0] shadow-2xl shadow-slate-900/10 p-6">

        <div class="flex items-start gap-4">
            <div class="flex-none w-11 h-11 rounded-xl bg-red-50 text-red-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 15l3-3-3-3m3 3H9"/>
                </svg>
            </div>

            <div>
                <h3 class="text-base font-bold text-[#0f172a]">Logout</h3>
                <p class="mt-1 text-sm text-[#64748b] leading-relaxed">
                    Are you sure you want to logout from your account?
                </p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 mt-6">
            <button type="button" id="logout-cancel-btn" class="px-4 py-2.5 rounded-xl text-sm font-medium text-[#64748b] hover:bg-[#f8fafc] hover:text-[#0f172a] transition-colors">
                Cancel
            </button>

            <form method="POST" action="/logout" id="logout-form">
                @csrf
                <button type="submit" class="px-4 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition-colors">
                    Logout
                </button>
            </form>
        </div>

    </div>
</div>