<x-mail::message>


- Import failure
- File: {{$upload->original_name}}
- Import Type: {{ ucwords($upload->import_type) }}
- Import File: {{ ucwords($upload->import_type_file) }}
- Time: {{ $upload->created_at }}



</x-mail::message>
