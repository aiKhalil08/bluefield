<x-layout name='{{$staff->name}}' role="Admin">
<x-slot:title>{{"$staff->name | Admin"}}</x-slot:title>
    <section data-title="{{"$staff->name | Admin"}}" class="content-container">
    <section class="content-section">
    <p>Hi, {{$staff->name}}</p>
    </section>
    </section>
</x-layout>