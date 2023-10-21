<layouts.book-manager>
    <x-slot:title>
        書籍登録
    </x-slot:title>
    <h1>書籍登録</h1>
    @if ($errors->any())
        {{-- <div style="color: red">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> --}}
        {{-- <x-error-messages :errors="$errors" /> --}}
        <x-alert class="danger">
            <x-error-messages :$errors />
        </x-alert>
    @endif
    <form action="{{ route('book.store') }}" method="POST">
        @csrf
        <x-book-form :$categories :$authors />
        <input type="submit" value="送信">
    </form>
</layouts.book-manager> 