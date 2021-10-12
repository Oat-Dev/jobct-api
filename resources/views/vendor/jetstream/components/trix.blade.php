@push('body-styles')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.css">
@endpush

<form x-data="form()">

<input x-ref="description" id="description" name="description" value='{{ $description }}' type="hidden" />
<div wire:ignore>
    <trix-editor input="description"></trix-editor>
</div>

<input x-ref="info" id="info" name="info" value='{{ $info }}' type="hidden" />
<div wire:ignore>
    <trix-editor input="info"></trix-editor>
</div>

<button x-on:click.prevent="save">Save</button>
</form>

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.0/trix.js"></script>
<script>
    function form() {
        return {
            save() {
                window.livewire.emit('alpineSave', {
                    info: this.$refs.info.value,
                    description: this.$refs.description.value,
                });
            }
        }
    }
</script>
@endpush

//livewire component
protected $listeners = ['alpineSave'];
public function alpineSave($array) {
        $this->fill([
            'info' => data_get($array, 'info'),
            'description' => data_get($array, 'description'),
        ]);
        // save the data ...
}