<x-mail::message>
# New message from your resume site

**From:** {{ $contactMessage->name }} &lt;{{ $contactMessage->email }}&gt;

<x-mail::panel>
{{ $contactMessage->message }}
</x-mail::panel>

<x-mail::button :url="route('admin.messages')">
Open inbox
</x-mail::button>

Reply to this email to respond directly.
</x-mail::message>
