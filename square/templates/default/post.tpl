{% include 'default' %}
{% if post %}
<article class="post">

  <h1 class="post-title">
    <a href="{{ site.url }}articles/{{ post.url }}">{{ post.title }}</a>
  </h1>

  <time datetime="{{ post.date  }}" class="post-date">{{ post.date | date: "%d %B, %Y" }}</time>

  <div class=content>
    {{ post.content }}
  </div>

</article>
{% else %}
No posts!
{% endif %}
{% include 'footer' %}
