<div id="Menu-bar" class="fixed bottom-[24px] px-[18px] max-w-[640px] w-full z-30">
    <div
        class="bg-white p-[14px_12px] rounded-full flex items-center justify-center gap-8 shadow-[0_8px_30px_0_#0A093212]">
        @foreach ($menus as $menu)
            <a href="{{ route($menu['route']) }}" wire:click="setActiveMenu('{{ $menu['route'] }}')">
                <div class="flex flex-col gap-1 items-center {{ $activeMenu == $menu['route'] ? 'text-[#4041DA]' : 'text-[#A0A3BD]' }}">
                    <div class="w-8 h-8 flex shrink-0">
                        <img src="{{ asset('assets/icons/' . $menu['icon']) }}" alt="icon">
                    </div>
                    <p class="{{ $activeMenu == $menu['route'] ? 'text-[#4041DA]' : 'text-[#A0A3BD]' }} text-xs leading-[18px] font-semibold">{{ $menu['name'] }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
