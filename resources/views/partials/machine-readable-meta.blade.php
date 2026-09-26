{{-- Discovery hints: tells agents and browsers where the machine-readable CV lives. --}}
<link rel="alternate" type="text/markdown" href="{{ route('cv.markdown') }}" title="{{ $user->fullName }} - CV (Markdown)">
<link rel="alternate" type="application/pdf" href="{{ route('downloadPDF') }}" title="{{ $user->fullName }} - CV (PDF)">
