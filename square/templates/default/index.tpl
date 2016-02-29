{% include 'default' %}
{% if posts %}
{% paginate posts by 1 %}
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

<ol class="nav pagination">
<li class="pagination__prev">{% if paginate.previous %}{% if paginate.previous_page == 1 %}<a href="/">Newer</a>{% else %}<a href="{{ paginate.previous.url }}">Newer</a>{% endif %}{% else %}Newer{% endif %}</li><!--
--><li class="pagination__next">{% if paginate.next %}<a href="{{ paginate.next.url }}">Older</a>{% else %}Older{% endif %}</li>
</ol>

{% endpaginate %}
{% else %}
No posts!
{% endif %}
