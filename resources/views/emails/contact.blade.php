@component('mail::message')
# Contact Email
## You have a new contact message from contact from :

- Name : {{$data['name']}}
- email : {{$data['email']}}
- subject : {{$data['subject']}}
- message : {{$data['message']}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
