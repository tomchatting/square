{% include 'default' %}
{% if posts %}
{% paginate posts by 5 %}
{% for post in posts %}
<article>

  <h1 class="post-title">
    <a href="{{ site.url }}articles/{{ post.url }}">{{ post.title }}</a>
  </h1>

  <time datetime="{{ post.date  }}" class="post-date">{{ post.date | date: "%d %B, %Y" }}</time>

  <div class=content>
    {{ post.content }}
  </div>

</article>
{% endfor %}

<div class="pagination">

    {% if paginate.next %}<a class="pagination-item older" href="{{ paginate.next.url }}">Older</a>{% else %}<span class="pagination-item older">Older</span>{% endif %}

    {% if paginate.previous %}{% if paginate.previous_page == 1 %}<a class="pagination-item newer" href="/">Newer</a>{% else %}<a class="pagination-item newer" href="{{ paginate.previous.url }}">Newer</a>{% endif %}{% else %}<span class="pagination-item newer">Newer</span>{% endif %}

</div>

{% endpaginate %}
{% else %}
No posts!
{% endif %}
{% include 'footer' %}
