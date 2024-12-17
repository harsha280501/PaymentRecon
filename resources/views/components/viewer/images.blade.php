@props(['filepath'])

@php
$filename = explode('/', $filepath);
$filename = $filename[count($filename) - 1];

$ext = explode('.', $filename);
$ext = $ext[count($ext) - 1];
@endphp

<div class="view__container" x-show="isOpen">
    <div class="view__display w-100">
        <div class="view__head w-100">

            <p class="filename">{{ $filename }}</p>
            <button @click="isOpen = false" style="background: transparent; border: none; outline: none; color: #fff">
                <i class="fa fa-close"></i>
            </button>
        </div>

        <div class="view__body">
            @if($ext == 'pdf')
            <iframe src="{{ $filepath }}" frameborder="0"></iframe>
            @elseif($ext == 'xlsx' || $ext == 'csv')
            <div style="color: #fff; display: flex; justify-content: center; align-items: center; flex-direction: column">
                <span>View action is Disabled for Csv,Xlsx files for Security Reasons</span>
                <span>You Can <a download href="{{ $filepath }}"> Download </a> them Instead</span>
            </div>

            @else
            <img src="{{ $filepath }}" alt="Image">
            @endif

        </div>
    </div>
</div>
