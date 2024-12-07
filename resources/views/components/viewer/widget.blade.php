@php
$filename = explode('/', $document);
$filename = $filename[count($filename) - 1];

$ext = explode('.', $filename);
$ext = $ext[count($ext) - 1];

@endphp


<div style="display: flex; justify-content: center; align-items: center; width: auto; height: auto; gap: 1em" x-data="{
    isOpen: false
}">

    @if ($document && $document != 'undefined')

    @if($ext != 'xlsx' && $ext != 'csv')
    <a style="text-decoration: none; color: #000" @click.prevent="isOpen = true">
        <i class="fa-solid fa-eye"></i>
    </a>
    @endif
    <a download style="text-decoration: none" href="{{ $document }}">
        <i class="fa-solid fa-download"></i>
    </a>

    <x-viewer.images :filepath="$document" />

    @else
    <p class="text-center" style="margin-top: -10px">NO
        FILE</p>
    @endif
</div>
