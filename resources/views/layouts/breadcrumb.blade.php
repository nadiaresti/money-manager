<?php if (!isset($breadcrumbs)) $breadcrumbs = []; ?>
<div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">{{ $title }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          @foreach ($breadcrumbs as $key => $item)
            @if($key == array_key_last($breadcrumbs))
            <li class="breadcrumb-item active">{{ $item['label'] }}</li>
            @else
            <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
            @endif
          @endforeach
        </ol>
      </div>
    </div>
</div>