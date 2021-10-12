<div>
    <!-- Reject Applicant Confirmation Modal -->
    <x-jet-dialog-modal wire:model="modalDeleteVisible">
        <x-slot name="title">
            {{ __('Reject Applicant (ID: '. $idSelecting .')') }}
        </x-slot>

        <x-slot name="content">
            {{  __('Are you sure you want to reject this applicant?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="rejectApplicant" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="rejectApplicant">{{ __('Confirm') }}</span>
                <span wire:loading wire:target="rejectApplicant">
                    <i class="fas fa-spinner fa-spin"></i> Processing
                </span>
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>