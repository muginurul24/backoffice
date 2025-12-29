<flux:sidebar.nav>
    <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                       wire:navigate>{{ __('Dashboard') }}</flux:sidebar.item>
    <flux:sidebar.item icon="globe" :href="route('site-management')" :current="request()->routeIs('site-management')"
                       wire:navigate>Site Management
    </flux:sidebar.item>
    <flux:sidebar.item icon="landmark" :href="route('bank-management')" :current="request()->routeIs('bank-management')"
                       wire:navigate>Bank Management
    </flux:sidebar.item>
    <flux:sidebar.item icon="users" :href="route('users')" wire:navigate>Users</flux:sidebar.item>
    <flux:sidebar.item icon="link" badge="{{$totalKyc}}" href="#" wire:navigate>Request KYC</flux:sidebar.item>
    <flux:sidebar.item icon="message-circle-more" badge="{{$totalMemo}}" href="#" wire:navigate>Memo</flux:sidebar.item>
    <flux:sidebar.group expandable heading="CRM" class="grid">
        <flux:sidebar.item href="#" wire:navigate>Promotor</flux:sidebar.item>
        <flux:sidebar.item href="#" wire:navigate>Downline</flux:sidebar.item>
    </flux:sidebar.group>
    <flux:sidebar.group expandable heading="Transactions" class="grid">
        <flux:sidebar.item href="#" badge="{{$totalPending}}" wire:navigate>Pending</flux:sidebar.item>
        <flux:sidebar.item href="#" wire:navigate>Manual</flux:sidebar.item>
        <flux:sidebar.item href="#" wire:navigate>History</flux:sidebar.item>
    </flux:sidebar.group>
    <flux:sidebar.group expandable heading="Config" class="grid">
        <flux:sidebar.item href="#" wire:navigate>Carousel</flux:sidebar.item>
        <flux:sidebar.item href="#" wire:navigate>Event</flux:sidebar.item>
        <flux:sidebar.item href="#" wire:navigate>Contact</flux:sidebar.item>
    </flux:sidebar.group>
    <flux:sidebar.group expandable heading="API" class="grid">
        <flux:sidebar.item href="#" wire:navigate>Turn Over</flux:sidebar.item>
        <flux:sidebar.item href="#" wire:navigate>Call Manage</flux:sidebar.item>
        <flux:sidebar.item href="#" wire:navigate>Call History</flux:sidebar.item>
        <flux:sidebar.item href="#" wire:navigate>Control RTP</flux:sidebar.item>
    </flux:sidebar.group>
</flux:sidebar.nav>

<flux:spacer/>

<flux:sidebar.nav>
    <flux:sidebar.item icon="coins" href="#" wire:navigate>Topup Balance</flux:sidebar.item>
    <flux:sidebar.item icon="history" href="#" wire:navigate>History Topup</flux:sidebar.item>
</flux:sidebar.nav>
