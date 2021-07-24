<div>
    <div x-data="{ tab: 'foo' }">
    <div x-show="tab === 'foo'">
        <button :class="{ 'active': tab === 'foo' }" @click="tab = 'bar'">Foo</button>
        <div >Tab Foo</div>
    </div>
    <div x-show="tab === 'bar'">
        <button :class="{ 'active': tab === 'bar' }" @click="tab = 'foo'">Bar</button>
        <div >Tab Bar</div>
    </div>
    </div>

    <div>
        <textarea wire:model.lazy='text' type="text"></textarea>
    </div>
    <div>
        {{$urlwords}}
    </div>
    
    <a wire:click.prevent="pdf()" class="btn btn-primary">
        PDF
    </a>
    <div class="row mt-5">
    <input wire:ignore class="form-control my-5 w-100" placeholder="Escribe direccion .." id="buscador" />
    </div>
</div>

