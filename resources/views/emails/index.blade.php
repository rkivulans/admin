<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1>Mailboxes</h1>
        
        @foreach ( $users as $user )
           {{ $user->name }} 
        @endforeach
        
    </div>
</x-app-layout>