@extends('kernel_page')

@section('content')
    <h4>Patch Information</h4>
    <patch-info-banner
        variant="danger"
        heading="Patch fix 1"
        description="Patch fix description"
        url-to-doc="https://www.google.com"
    >
    </patch-info-banner>
    <patch-info-banner
        variant="primary"
        heading="Patch fix 2"
        description="Patch fix description"
        url-to-doc="https://www.google.com"
    >
    </patch-info-banner>
    <patch-info-banner
        variant="primary"
        heading="Patch fix 3"
        description="Patch fix description"
        url-to-doc="https://www.google.com"
    >
    </patch-info-banner>
    <patch-info-banner
        variant="primary"
        heading="Patch fix 4"
        description="Patch fix description"
        url-to-doc="https://www.google.com"
    >
    </patch-info-banner>
@endsection
