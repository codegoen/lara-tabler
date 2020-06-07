<div 
    role="alert"
    class="
        alert alert-{{ $type }}
        @isset ($dismiss)
            alert-dismissible
        @endisset
    "
    >
    {{ $slot }}
    @isset ($dismiss)
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    @endisset
</div>
