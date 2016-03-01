{% include 'default' %}
{% if page %}
<article>

  <h1 class="article-title">
    <a href="{{ site.url }}{{ page.url }}">{{ page.title }}</a>
  </h1>

  <time datetime="{{ post.date  }}" class="post-date">{{ post.date | date: "%d %B, %Y" }}</time>

  <div class=content>
    {{ page.content }}
  </div>

</article>
{% else %}
404
{% endif %}
