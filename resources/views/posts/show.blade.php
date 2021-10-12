<script>
    function DisableButton(btn){
    btn.disabled=true;
    btn.value='送信中...';
    btn.form.submit();
}
</script>

<x-app-layout>
    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-white shadow-md">
        <x-validation-errors />
        <x-flash-message :message="session('notice')" />
        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $post->title }}</h2>
            <h3>{{ $post->user->name }}</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $post->created_at ? 'NEW' : '' }}</span>
                {{ $post->created_at }}
            </p>
            <img src="{{ Storage::url($post->image) }}" alt="image" class="mb-4">
            <p class="text-gray-700 text-base mb-3">{!! nl2br(e($post->body)) !!}</p>
            @auth
            @if ($like)
                <a href="{{ route('unlike', $post) }}" onclick="if(!confirm('お気に入りを解除しますか？')){return false};" class="bg-pink-400 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2 mt-2 mb-2">
                    お気に入り削除
                </a>
            @else
                <a href="{{ route('like', $post) }}" onclick="if(!confirm('お気に入りにしますか？')){return false};" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2 mt-2 mb-2">
                    お気に入り
                </a>
            @endif
            <p class="mt-3">お気に入り数: {{ $post->likes->count() }}</p>
            @endauth
        </article>
        <div class="flex flex-row text-center my-4">
            @can('update', $post)
                <a href="{{ route('posts.edit', $post) }}"
                    class="bg-indigo-400 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            @endcan
            @can('delete', $post)
                <form action="{{ route('posts.destroy', $post) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="削除" onclick="if(!confirm('削除しますか？')){return false};"
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                </form>
            @endcan
        </div>
    </div>
</x-app-layout>
