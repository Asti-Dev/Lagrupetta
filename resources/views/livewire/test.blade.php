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
    
    
    <a wire:click.prevent="pdf()" class="btn btn-primary">
        PDF
    </a>
</div>
