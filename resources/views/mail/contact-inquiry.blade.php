<x-mail::message>
# New website enquiry

**Name:** {{ $inquiry['name'] }}<br>
**E-mail:** {{ $inquiry['email'] }}<br>
**Company:** {{ $inquiry['company'] ?: '-' }}<br>
**Phone:** {{ $inquiry['phone'] ?: '-' }}<br>
**Service:** {{ $inquiry['service'] }}<br>
**Budget:** {{ $inquiry['budget'] ?: '-' }}

<x-mail::panel>
{{ $inquiry['message'] }}
</x-mail::panel>

Reply to this e-mail to respond directly to {{ $inquiry['name'] }}.
</x-mail::message>
