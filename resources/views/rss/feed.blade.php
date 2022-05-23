<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ Laravel From Scratch Blog ]]></title>
        <link><![CDATA[ http://localhost:8000 ]]></link>
        <description><![CDATA[ Latest Laravel From Scratch News ]]></description>
        <language>en</language>
        <pubDate>{{ now() }}</pubDate>

        @foreach($posts as $post)
            <item>
                <title><![CDATA[{{ $post->title }}]]></title>
                <link>/post/{{ $post->slug }}</link>
                <description><![CDATA[{!! $post->body !!}]]></description>
                <category>{{ $post->category->name }}</category>
                <author><![CDATA[{{ $post->author->username }}]]></author>
                <guid>{{ $post->id }}</guid>
                <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
