<div class="max-w-7xl mx-auto min-h-screen pb-20" 
     x-data="{ 
        toast: false, 
        message: '', 
        type: 'success',
        showToast(msg, t = 'success') {
            this.message = msg;
            this.type = t;
            this.toast = true;
            setTimeout(() => this.toast = false, 3000);
        }
     }"
     @notify.window="showToast($event.detail.message, $event.detail.type || 'success')"
>
    @include('livewire.admin.earnings.header')

    @include('livewire.admin.earnings.filters')

    @include('livewire.admin.earnings.table')

    @include('livewire.admin.earnings.form-modal')

    @include('livewire.admin.earnings.toast')

</div>