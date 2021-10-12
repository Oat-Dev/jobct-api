<div>
  <!-- Delete Job Confirmation Modal -->
  <x-jet-dialog-modal wire:model="modalDeleteVisible">
    <x-slot name="title">
      {{ __('Delete Job (ID: '. $idSelecting .')') }}
    </x-slot>

    <x-slot name="content">
      {{  __('Are you sure you want to delete this job?') }}
    </x-slot>

    <x-slot name="footer">
      <x-jet-secondary-button wire:click="$toggle('modalDeleteVisible')" wire:loading.attr="disabled">
        {{ __('Cancel') }}
      </x-jet-secondary-button>

      <x-jet-danger-button class="ml-2" wire:click="deleteJob" wire:loading.attr="disabled">
        <span wire:loading.remove wire:target="deleteJob">{{ __('Confirm') }}</span>
        <span wire:loading wire:target="deleteJob">
          <i class="fas fa-spinner fa-spin"></i> Processing
        </span>
      </x-jet-danger-button>
    </x-slot>
  </x-jet-dialog-modal>
</div>