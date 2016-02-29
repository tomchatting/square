{% include 'default' %}
{% if posts %}
{% for post in posts %}
<article>

  <h1 class="article-title" title="{{ post.date }}">
    <a href="articles/{{ post.url }}">{{ post.title }}</a>
  </h1>

  <date>{{ post.date | date: "%d %B, %Y" }}</date>

  <div class=content>
    {{ post.content }}
  </div>

</article>
{% endfor %}
{% else %}
No posts!
{% endif %}
