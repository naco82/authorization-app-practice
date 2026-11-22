<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿一覧</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #1f2937;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .user-info {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info p {
            color: #1e40af;
        }

        .logout-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #dc2626;
        }

        .post-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .post-card h2 {
            color: #1f2937;
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .post-card .meta {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        .post-card .content {
            color: #374151;
            margin-bottom: 1rem;
        }

        .post-card .actions {
            display: flex;
            gap: 0.5rem;
        }

        .post-card .actions a,
        .post-card .actions button {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.875rem;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-edit {
            background: #3b82f6;
            color: white;
            border: none;
        }

        .btn-edit:hover {
            background: #2563eb;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background: #dc2626;
        }

        .empty {
            color: #6b7280;
            text-align: center;
            padding: 2rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>投稿一覧</h1>

        @auth
            <div class="user-info">
                <p>ログイン中：{{ Auth::user()->name }}</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">ログアウト</button>
                </form>
            </div>
        @endauth

        @forelse ($posts as $post)
            <div class="post-card">
                <h2>{{ $post->title }}</h2>
                <div class="meta">
                    投稿者: {{ $post->user->name ?? '不明' }} | 投稿日: {{ $post->created_at->format('Y/m/d H:i') }}
                </div>
                <div class="content">
                    {{ $post->content }}
                </div>

                <div class="actions">
                    @can('update', $post)
                        <a href="/posts/{{ $post->id }}/edit" class="btn-edit">編集</a>
                    @endcan

                    @can('delete', $post)
                        <form action="/posts/{{ $post->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">削除</button>
                        </form>
                    @endcan
                </div>

                @cannot('update', $post)
                <P style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;">編集する権限がありません</P>
                @endcannot
            </div>
        @empty
            <p class="empty">投稿がありません。 </p>
        @endforelse
    </div>
</body>

</html>