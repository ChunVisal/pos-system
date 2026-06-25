<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ---------- SUB-NAV TAB SWITCHING ----------
        const tabs = document.querySelectorAll('.settings-tab');
        const panels = document.querySelectorAll('.settings-panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.classList.remove('text-[#0F6E8C]', 'border-[#0F6E8C]',
                        'font-semibold');
                    t.classList.add('text-gray-500', 'dark:text-zinc-400',
                        'font-medium', 'border-transparent');
                });
                tab.classList.add('text-[#0F6E8C]', 'border-[#0F6E8C]', 'font-semibold');
                tab.classList.remove('text-gray-500', 'dark:text-zinc-400', 'font-medium',
                    'border-transparent');

                panels.forEach(p => p.classList.add('hidden'));
                document.getElementById('settings-' + tab.dataset.tab).classList.remove(
                    'hidden');
            });
        });

        // ---------- TOGGLE SWITCHES ----------
        document.querySelectorAll('.settings-toggle').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const dot = toggle.querySelector('.toggle-dot');
                const isOn = toggle.classList.contains('bg-[#0F6E8C]');
                toggle.classList.toggle('bg-[#0F6E8C]', !isOn);
                toggle.classList.toggle('bg-gray-300', isOn);
                toggle.classList.toggle('dark:bg-zinc-700', isOn);
                dot.classList.toggle('translate-x-5', !isOn);
                dot.classList.toggle('translate-x-1', isOn);
            });
        });

        // ---------- TAX MODE PILL BUTTONS ----------
        document.querySelectorAll('#settings-tax .grid.grid-cols-2 button').forEach(btn => {
            btn.addEventListener('click', () => {
                btn.parentElement.querySelectorAll('button').forEach(b => {
                    b.classList.remove('bg-[#0F6E8C]/10', 'dark:bg-[#0F6E8C]/30',
                        'border-[#0F6E8C]', 'text-[#0F6E8C]');
                    b.classList.add('border-gray-300', 'dark:border-zinc-700',
                        'text-gray-500', 'dark:text-zinc-400');
                });
                btn.classList.add('bg-[#0F6E8C]/10', 'dark:bg-[#0F6E8C]/30', 'border-[#0F6E8C]',
                    'text-[#0F6E8C]');
                btn.classList.remove('border-gray-300', 'dark:border-zinc-700', 'text-gray-500',
                    'dark:text-zinc-400');
            });
        });
    });
</script>
