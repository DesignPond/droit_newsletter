<link rel="stylesheet" href="{{ asset('newsletter/css/backend/newsletter.css') }}">
<link rel="stylesheet" href="{{ asset('newsletter/css/frontend/newsletter.css') }}">
@if(isset($campagne) && isset($campagne->newsletter))
    <style type="text/css">
        #StyleNewsletter h2, #StyleNewsletterCreate h2{
            color: {{ $campagne->newsletter->color }};
        }
        #StyleNewsletter .contentForm h3,
        #StyleNewsletter .contentForm h4,
        #StyleNewsletterCreate .contentForm h3,
        #StyleNewsletterCreate .contentForm h4
        {
            color: {{ $campagne->newsletter->color }};
        }
    </style>
@endif