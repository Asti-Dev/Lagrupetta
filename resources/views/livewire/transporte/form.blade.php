<div>
    <div class="form-group">
        <strong>Observacion:</strong>
        <textarea class="form-control" wire:model.debounce.2s="observacion" name="observacion" id="observacion" rows="3"></textarea>
        @error('observacion') <span>{{$message}}</span> @enderror
    </div>
</div>