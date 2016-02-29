{% include 'default' %}
{% if post %}
<article>

  <h1 class="article-title" title="{{ post.date }}">
    <a href="{{ site.url }}articles/{{ post.url }}">{{ post.title }}</a>
  </h1>

  <date>{{ post.date | date: "%d %B, %Y" }}</date>

  <div class=content>
    {{ post.content }}
  </div>

</article>
{% else %}
No posts!
{% endif %}
